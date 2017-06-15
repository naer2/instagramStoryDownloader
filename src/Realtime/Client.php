<?php

namespace InstagramAPI\Realtime;

use Clue\React\Socks\Client as SocksProxy;
use InstagramAPI\Client as HttpClient;
use InstagramAPI\Instagram;
use InstagramAPI\Realtime;
use InstagramAPI\Realtime\Utils\HttpConnectProxy;
use React\Dns\Resolver\Factory as DnsFactory;
use React\EventLoop\LoopInterface;
use React\EventLoop\Timer\TimerInterface;
use React\SocketClient\ConnectorInterface;
use React\SocketClient\DnsConnector;
use React\SocketClient\SecureConnector;
use React\SocketClient\TcpConnector;
use React\SocketClient\TimeoutConnector;

abstract class Client
{
    const DNS_SERVER = '8.8.8.8';

    const CONNECTION_TIMEOUT = 5;

    const KEEPALIVE_INTERVAL = 30;

    /** @var float Minimum reconnection interval (in sec) */
    const MIN_RECONNECT_INTERVAL = 0.5;
    /** @var float Maximum reconnection interval (in sec) */
    const MAX_RECONNECT_INTERVAL = 300; // 5 minutes

    /** @var string */
    protected $_id;

    /** @var Instagram */
    protected $_instagram;

    /** @var Realtime */
    protected $_rtc;

    /** @var TimerInterface */
    protected $_keepaliveTimer;

    /** @var float */
    protected $_keepaliveTimerInterval;

    /** @var TimerInterface */
    protected $_reconnectTimer;

    /** @var float */
    protected $_reconnectTimerInterval;

    /** @var bool */
    protected $_shutdown;

    /** @var bool */
    protected $_isConnected;

    /** @var bool */
    protected $_debug;

    /** @var \JsonMapper */
    protected $_mapper;

    /**
     * Handle client-specific params.
     *
     * @param array $params
     *
     * @return mixed
     */
    abstract protected function _handleParams(
        array $params);

    /**
     * Constructor.
     *
     * @param string    $id
     * @param Realtime  $rtc
     * @param Instagram $instagram
     * @param array     $params
     */
    public function __construct(
        $id,
        Realtime $rtc,
        Instagram $instagram,
        array $params = [])
    {
        $this->_id = $id;
        $this->_rtc = $rtc;
        $this->_instagram = $instagram;
        $this->_shutdown = false;
        $this->_isConnected = false;
        $this->_debug = $rtc->debug;
        $this->_handleParams($params);

        // Create our JSON object mapper and set global default options.
        $this->_mapper = new \JsonMapper();
        $this->_mapper->bStrictNullTypes = false; // Allow NULL values.
    }

    /**
     * Return stored Instagram object.
     *
     * @return Instagram
     */
    public function getInstagram()
    {
        return $this->_instagram;
    }

    /**
     * Return stored Instagram client.
     *
     * @return Realtime
     */
    public function getRtc()
    {
        return $this->_rtc;
    }

    /**
     * Return client's identifier.
     *
     * @return string
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @param object $data
     * @param object $reference
     *
     * @throws \JsonMapper_Exception
     *
     * @return object
     */
    public function mapToJson(
        $data,
        $reference)
    {
        // Use API developer debugging? Throws if class lacks properties.
        $this->_mapper->bExceptionOnUndefinedProperty = $this->_instagram->apiDeveloperDebug;

        // Perform mapping of all object properties.
        $result = $this->_mapper->map($data, $reference);

        return $result;
    }

    /**
     * Print debug message.
     *
     * @param string $message
     */
    public function debug(
        $message)
    {
        if (!$this->_debug) {
            return;
        }

        $now = date('H:i:s');
        if (func_num_args() > 1) {
            $args = func_get_args();
            $message = array_shift($args);
            $message = '[%s] [%s] '.$message.PHP_EOL;
            array_unshift($args, $this->_id);
            array_unshift($args, $now);
            array_unshift($args, $message);
            call_user_func_array('printf', $args);
        } else {
            printf('[%s] [%s] %s%s', $now, $this->_id, $message, PHP_EOL);
        }
    }

    /**
     * onKeepaliveTimer event.
     */
    public function onKeepaliveTimer()
    {
        $this->_disconnect();
    }

    /**
     * Emit onKeepaliveTimer event.
     *
     * @param string $pool
     */
    public function emitKeepaliveTimer()
    {
        $this->_keepaliveTimer = null;
        $this->debug('Keepalive timer is fired');
        $this->onKeepaliveTimer();
    }

    /**
     * Cancel keepalive timer.
     */
    public function cancelKeepaliveTimer()
    {
        if ($this->_keepaliveTimer === null) {
            return;
        }
        // Cancel existing timer.
        $this->_keepaliveTimer->cancel();
        $this->_keepaliveTimer = null;
        $this->debug('Existing keepalive timer has been cancelled');
    }

    /**
     * Cancel reconnect timer.
     */
    public function cancelReconnectTimer()
    {
        if ($this->_reconnectTimer === null) {
            return;
        }
        // Cancel existing timer.
        $this->_reconnectTimer->cancel();
        $this->_reconnectTimer = null;
        $this->debug('Existing reconnect timer has been cancelled');
    }

    /**
     * Update keepalive interval (if needed) and set keepalive timer.
     *
     * @param float|null $interval
     */
    public function setKeepaliveTimer(
        $interval = null)
    {
        // Cancel existing timer to prevent double-firing.
        $this->cancelKeepaliveTimer();
        // Do not keepalive on shutdown.
        if ($this->_shutdown) {
            return;
        }
        // Do not set timer if we don't have interval yet.
        if ($interval === null && $this->_keepaliveTimerInterval === null) {
            return;
        }
        // Update interval if new value was supplied.
        if ($interval !== null) {
            $this->_keepaliveTimerInterval = max(0, $interval);
        }
        // Set up new timer.
        $this->debug('Setting up keepalive timer to %.1f seconds', $this->_keepaliveTimerInterval);
        $this->_keepaliveTimer = $this->_rtc->getLoop()->addTimer($this->_keepaliveTimerInterval, function () {
            $this->emitKeepaliveTimer();
        });
    }

    /**
     * Establish connection.
     */
    abstract protected function _connect();

    /**
     * Update reconnect interval and set up reconnect timer.
     *
     * @param float $interval
     */
    public function setReconnectTimer(
        $interval)
    {
        // Cancel existing timers to prevent double-firing.
        $this->cancelKeepaliveTimer();
        $this->cancelReconnectTimer();
        // Do not reconnect on shutdown.
        if ($this->_shutdown) {
            return;
        }
        // We must keep interval sane.
        $this->_reconnectTimerInterval = max(0.1, min($interval, self::MAX_RECONNECT_INTERVAL));
        $this->debug('Setting up connection timer to %.1f seconds', $this->_reconnectTimerInterval);
        // Set up new timer.
        $this->_reconnectTimer = $this->_rtc->getLoop()->addTimer($this->_reconnectTimerInterval, function () {
            $this->_keepaliveTimerInterval = self::KEEPALIVE_INTERVAL;
            $this->_connect();
        });
    }

    /**
     * Perform first connection in a row.
     */
    final public function connect()
    {
        $this->setReconnectTimer(self::MIN_RECONNECT_INTERVAL);
    }

    /**
     * Perform reconnection after previous failed attempt.
     */
    final public function reconnect()
    {
        // Implement progressive delay.
        $this->setReconnectTimer($this->_reconnectTimerInterval * 2);
    }

    /**
     * Disconnect from server.
     */
    abstract protected function _disconnect();

    /**
     * Proxy for _disconnect().
     */
    final public function shutdown()
    {
        if (!$this->_isConnected) {
            return;
        }
        $this->debug('Shutting down');
        $this->_shutdown = true;
        $this->_disconnect();
    }

    /**
     * Update sequence for given topic.
     *
     * @param string $topic
     * @param string $sequence
     */
    abstract public function onUpdateSequence(
        $topic,
        $sequence);

    /**
     * Handle requested refresh.
     */
    abstract public function onRefreshRequested();

    /**
     * Handle subscribed event.
     *
     * @param string $topic
     */
    abstract public function onSubscribedTo(
        $topic);

    /**
     * Handle unsubscribed event.
     *
     * @param string $topic
     */
    abstract public function onUnsubscribedFrom(
        $topic);

    /**
     * @param string $host
     *
     * @return null|string
     */
    protected function _getProxyAddress(
        $host)
    {
        $proxy = $this->_instagram->getProxy();
        if (!is_array($proxy)) {
            return $proxy;
        }

        if (!isset($proxy['https'])) {
            throw new \InvalidArgumentException('No proxy with CONNECT method found');
        }

        if (isset($proxy['no']) && \GuzzleHttp\is_host_in_noproxy($host, $proxy['no'])) {
            return;
        }

        return $proxy['https'];
    }

    /**
     * @param string             $proxyAddress
     * @param ConnectorInterface $connector
     * @param LoopInterface      $loop
     *
     * @return HttpConnectProxy|SocksProxy
     */
    protected function _getProxyConnector(
        $proxyAddress,
        ConnectorInterface $connector,
        LoopInterface $loop)
    {
        if (strpos($proxyAddress, '://') === false) {
            $scheme = 'http';
        } else {
            $scheme = parse_url($proxyAddress, PHP_URL_SCHEME);
        }

        switch ($scheme) {
            case 'socks':
            case 'socks4':
            case 'socks4a':
            case 'socks5':
                return new SocksProxy($proxyAddress, $connector);
            case 'http':
                return new HttpConnectProxy($proxyAddress, $connector);
            case 'https':
                $ssl = new SecureConnector($connector, $loop, $this->_getSecureContext());

                return new HttpConnectProxy($proxyAddress, $ssl);
            default:
                throw new \InvalidArgumentException(sprintf('Unsupported proxy scheme: %s', $scheme));
        }
    }

    /**
     * Fetch secure context from parent Instagram object.
     *
     * @return array
     */
    protected function _getSecureContext()
    {
        $context = [];
        $value = $this->_instagram->getVerifySSL();
        if ($value === true) {
            // PHP 5.6 or greater will find the system cert by default. When
            // < 5.6, use the Guzzle bundled cacert.
            if (PHP_VERSION_ID < 50600) {
                $context['cafile'] = \GuzzleHttp\default_ca_bundle();
            }
        } elseif (is_string($value)) {
            $context['cafile'] = $value;
            if (!file_exists($value)) {
                throw new \RuntimeException("SSL CA bundle not found: $value");
            }
        } elseif ($value === false) {
            $context['verify_peer'] = false;
            $context['verify_peer_name'] = false;

            return $context;
        } else {
            throw new \InvalidArgumentException('Invalid verify request option');
        }
        $context['verify_peer'] = true;
        $context['verify_peer_name'] = true;
        $context['allow_self_signed'] = false;

        return $context;
    }

    /**
     * @param string $url
     * @param bool   $secure
     *
     * @return ConnectorInterface
     */
    public function getConnector(
        $url,
        $secure)
    {
        $host = parse_url($url, PHP_URL_HOST);
        $loop = $this->_rtc->getLoop();
        // Use Google resolver.
        $dnsFactory = new DnsFactory();
        $resolver = $dnsFactory->create(self::DNS_SERVER, $loop);
        // Initial connection.
        $tcp = new TcpConnector($loop);
        // Lookup hostname / proxy.
        $dns = new DnsConnector($tcp, $resolver);
        // Proxy connection (optional).
        $proxy = $this->_getProxyAddress($host);
        if ($proxy !== null) {
            $dns = $this->_getProxyConnector($proxy, $dns, $loop);
        }
        // Check for secure.
        if ($secure) {
            $dns = new SecureConnector($dns, $loop, $this->_getSecureContext());
        }
        // Set connection timeout.
        return new TimeoutConnector($dns, self::CONNECTION_TIMEOUT, $loop);
    }

    /**
     * Check if feature is enabled.
     *
     * @param array  $params
     * @param string $feature
     *
     * @return bool
     */
    public static function isFeatureEnabled(
        array $params,
        $feature)
    {
        if (!isset($params[$feature])) {
            return false;
        }

        return in_array($params[$feature], ['enabled', 'true', '1']);
    }

    /**
     * Send command.
     *
     * @param string $command
     *
     * @return bool
     */
    abstract protected function _sendCommand(
        $command);

    /**
     * Checks whether we can send something.
     *
     * @return bool
     */
    public function isSendingAvailable()
    {
        return $this->_isConnected;
    }

    /**
     * Proxy for _sendCommand().
     *
     * @param string $command
     *
     * @return bool
     */
    public function sendCommand(
        $command)
    {
        if (!$this->isSendingAvailable()) {
            return false;
        }
        try {
            return $this->_sendCommand($command);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Handle incoming action.
     *
     * @param Action $action
     */
    protected function _handleAction(
        Action $action)
    {
        $action->handle($this);
    }

    /**
     * Process incoming action.
     *
     * @param object $message
     */
    protected function _processAction(
        $message)
    {
        $this->debug('Received action "%s"', $message->action);
        switch ($message->action) {
            case Action::ACK:
                /** @var Action\Ack $action */
                $action = $this->mapToJson($message, new Action\Ack());
                break;
            case Action::UNSEEN_COUNT:
                /** @var Action\Unseen $action */
                $action = $this->mapToJson($message, new Action\Unseen());
                break;
            default:
                $this->debug('Action "%s" is ignored (unknown type)', $message->action);

                return;
        }
        $this->_handleAction($action);
    }

    /**
     * Handle incoming event.
     *
     * @param Event $event
     */
    protected function _handleEvent(
        Event $event)
    {
        $event->handle($this);
    }

    /**
     * Process incoming event.
     *
     * @param object $message
     */
    protected function _processEvent(
        $message)
    {
        $this->debug('Received event "%s"', $message->event);
        switch ($message->event) {
            case Event::SUBSCRIBED:
                /** @var Event\Subscribed $event */
                $event = $this->mapToJson($message, new Event\Subscribed());
                break;
            case Event::UNSUBSCRIBED:
                /** @var Event\Unsubscribed $event */
                $event = $this->mapToJson($message, new Event\Unsubscribed());
                break;
            case Event::KEEPALIVE:
                /** @var Event\Keepalive $event */
                $event = $this->mapToJson($message, new Event\Keepalive());
                break;
            case Event::PATCH:
                /** @var Event\Patch $event */
                $event = $this->mapToJson($message, new Event\Patch());
                break;
            case Event::BROADCAST_ACK:
                /** @var Event\BroadcastAck $event */
                $event = $this->mapToJson($message, new Event\BroadcastAck());
                break;
            case Event::ERROR:
                /** @var Event\Error $event */
                $event = $this->mapToJson($message, new Event\Error());
                break;
            default:
                $this->debug('Event "%s" is ignored (unknown type)', $message->event);

                return;
        }
        $this->_handleEvent($event);
    }

    /**
     * Process incoming message.
     *
     * @param string $message
     */
    protected function _processMessage(
        $message)
    {
        $this->debug('Received message %s', $message);
        $message = HttpClient::api_body_decode($message);
        if (isset($message->event)) {
            $this->_processEvent($message);
        } elseif (isset($message->action)) {
            $this->_processAction($message);
        } else {
            $this->debug('Invalid message (both event and action are missing)');
        }
    }
}
