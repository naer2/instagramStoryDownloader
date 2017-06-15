<?php

namespace InstagramAPI\Realtime\Client;

use InstagramAPI\Constants;
use InstagramAPI\Realtime;
use InstagramAPI\Realtime\Client;
use InstagramAPI\Realtime\Client\WebSocket\Connector;
use InstagramAPI\Realtime\Event;
use InstagramAPI\Response\Model\Subscription;
use Ratchet\Client\WebSocket as WebSocketClient;
use Ratchet\RFC6455\Messaging\MessageInterface;

class WebSocket extends Client
{
    const COMMAND_SUBSCRIBE = 'subscribe';
    const COMMAND_UNSUBSCRIBE = 'unsubscribe';

    /** @var Subscription */
    protected $_subscription;

    /** @var bool */
    protected $_isSubscribed;

    /** @var WebSocketClient */
    protected $_connection;

    /** @var bool */
    protected $_isMqttReceiveEnabled;

    /** {@inheritdoc} */
    protected function _handleParams(
        array $params)
    {
        // MQTT params.
        if (isset($params['isMqttReceiveEnabled'])) {
            $this->_isMqttReceiveEnabled = (bool) $params['isMqttReceiveEnabled'];
        } else {
            $this->_isMqttReceiveEnabled = false;
        }

        // Init subscription.
        $this->_isSubscribed = false;
        $this->_initSubscription();
    }

    /**
     * Return current subscription model.
     *
     * @return Subscription
     */
    public function getSubscription()
    {
        return $this->_subscription;
    }

    /**
     * Override parent method to check for subscription status.
     *
     * @return bool
     */
    public function isSendingAvailable()
    {
        return parent::isSendingAvailable() && $this->_isSubscribed;
    }

    /** {@inheritdoc} */
    protected function _sendCommand(
        $command)
    {
        $this->debug('Sending command %s', $command);
        $this->_connection->send($command);

        return true;
    }

    /**
     * Runs self::COMMAND_SUBSCRIBE.
     */
    protected function _subscribe()
    {
        if ($this->_isSubscribed) {
            return;
        }
        $this->debug('Subscribing to "%s"', $this->_subscription->topic);
        $this->_sendCommand(Realtime::jsonEncode([
            'auth'     => $this->_subscription->auth,
            'command'  => self::COMMAND_SUBSCRIBE,
            'sequence' => $this->_subscription->sequence,
            'topic'    => $this->_subscription->topic,
        ]));
    }

    /**
     * Runs self::COMMAND_UNSUBSCRIBE.
     *
     * @param string $topic
     */
    protected function _unsubscribe(
        $topic)
    {
        $this->debug('Unsubscribing from "%s"', $topic);
        $this->_sendCommand(Realtime::jsonEncode([
            'command' => self::COMMAND_UNSUBSCRIBE,
            'topic'   => $topic,
        ]));
    }

    /**
     * Incoming message handler.
     *
     * @param MessageInterface $msg
     */
    protected function _onReceive(
        MessageInterface $msg)
    {
        $contents = $msg->__toString();
        if ($msg->isBinary()) {
            $contents = zlib_decode($contents);
            if ($contents === false) {
                $this->debug('Failed to inflate binary message');

                return;
            }
        }
        $this->_processMessage($contents);
    }

    /**
     * @param WebSocketClient $connection
     */
    protected function _afterConnect(
        WebSocketClient $connection)
    {
        $connection->on('message', function (MessageInterface $msg) {
            $this->_onReceive($msg);
            // Refresh keepalive timer.
            $this->setKeepaliveTimer();
        });

        $connection->on('close', function ($code = null, $reason = null) {
            $this->debug('Disconnected from websocket');
            $this->_connection = null;
            $this->_isConnected = false;
            $this->_isSubscribed = false;
            $this->connect();
        });

        $connection->on('ping', function () {
            $this->debug('ping was received');
            // Refresh keepalive timer.
            $this->setKeepaliveTimer();
        });

        $connection->on('pong', function () {
            $this->debug('pong was received');
            // Refresh keepalive timer.
            $this->setKeepaliveTimer();
        });

        $connection->on('error', function ($error = null) use ($connection) {
            // Close connection on error.
            $this->debug('Closing connection because of stream error');
            $connection->close();
        });

        $this->debug('Connected, restoring subscription');
        $this->_connection = $connection;
        $this->_isConnected = true;
        $this->_subscribe();
    }

    /** {@inheritdoc} */
    protected function _connect()
    {
        $url = $this->_subscription->url;
        $this->debug('Connecting to "%s"', $url);
        $connector = new Connector($this->getConnector($url, false), $this->getConnector($url, true));
        $headers = [
            'User-Agent'        => $this->_instagram->device->getUserAgent(),
            'Accept-Language'   => Constants::ACCEPT_LANGUAGE,
            'Accept-Encoding'   => 'gzip',
            'X-IG-Capabilities' => Constants::X_IG_Capabilities,
            'X-IG-Mqtt'         => (int) $this->_isMqttReceiveEnabled,
        ];
        $connector($url, [], $headers)->then(function (WebSocketClient $conn) {
            $this->_afterConnect($conn);
        }, function (\Exception $e) {
            $this->debug($e->getMessage());
            $this->debug('Retrying connection because of error');
            $this->reconnect();
        });
    }

    /** {@inheritdoc} */
    public function onUpdateSequence(
        $topic,
        $sequence)
    {
        $this->debug('Updating sequence for topic "%s" to "%s"', $topic, $sequence);
        if ($this->_subscription->topic != $topic) {
            $this->debug('We aren\'t subscribed to topic "%s"', $topic);

            return;
        }
        if (strcmp($sequence, $this->_subscription->sequence) <= 0) {
            $this->debug('Topic "%s" already has latest sequence ("%s")', $topic, $this->_subscription->sequence);

            return;
        }
        $this->_subscription->sequence = $sequence;
        $this->debug('Sequence for topic "%s" is updated to "%s"', $topic, $this->_subscription->sequence);
    }

    protected function _initSubscription()
    {
        $inbox = $this->_instagram->direct->getInbox();
        $subscription = $inbox->subscription;
        if (!$subscription instanceof Subscription) {
            throw new \InvalidArgumentException('Can not subscribe to inbox.');
        }
        $this->_subscription = $subscription;
    }

    /**
     * Refresh subscription.
     */
    protected function _refreshSubscription()
    {
        $this->_isSubscribed = false;
        $this->_unsubscribe($this->_subscription->topic);
        $this->_initSubscription();
    }

    /** {@inheritdoc} */
    public function onRefreshRequested()
    {
        if ($this->_isMqttReceiveEnabled) {
            return;
        }
        try {
            $this->_refreshSubscription();
        } catch (\Exception $e) {
            $this->_rtc->emit('error', [$e]);
        }
    }

    /** {@inheritdoc} */
    public function onSubscribedTo(
        $topic)
    {
        if ($this->_subscription->topic !== $topic) {
            $this->debug(sprintf('Subscribed to unknown topic %s', $topic));

            return;
        }
        $this->_isSubscribed = true;
        $this->debug('Successfully subscribed');
    }

    /** {@inheritdoc} */
    public function onUnsubscribedFrom(
        $topic)
    {
        if ($this->_subscription->topic !== $topic) {
            $this->debug(sprintf('Unsubscribed from unknown topic %s', $topic));

            return;
        }
        $this->_isSubscribed = false;
        $this->debug('Restoring subscription after unsubscribed event');
        $this->_subscribe();
    }

    /** {@inheritdoc} */
    protected function _disconnect()
    {
        if ($this->_connection === null) {
            return;
        }
        $this->_connection->close();
    }

    /**
     * Override parent method to skip events from unknown topics.
     *
     * @param Event $event
     */
    protected function _handleEvent(
        Event $event)
    {
        if (!isset($event->topic)
            || $this->_subscription->topic === $event->topic
            || substr($event->topic, 0, 4) === 'live') {
            parent::_handleEvent($event);
        } else {
            $this->debug('Received message from unknown topic "%s"', $event->topic);
            $this->_unsubscribe($event->topic);
        }
    }
}
