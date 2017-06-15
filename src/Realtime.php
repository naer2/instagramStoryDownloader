<?php

namespace InstagramAPI;

use Evenement\EventEmitterInterface;
use Evenement\EventEmitterTrait;
use InstagramAPI\Realtime\Client as RealtimeClient;
use React\EventLoop\LoopInterface;
use React\EventLoop\Timer\TimerInterface;
use React\Promise\FulfilledPromise;
use React\Promise\PromiseInterface;
use React\Promise\RejectedPromise;

/**
 * The following events are emitted:
 *  - live-started - New live broadcast has been started.
 *  - live-stopped - An existing live broadcast has been stopped.
 *  - direct-story-created - New direct story has been created.
 *  - direct-story-updated - New item has been created in direct story.
 *  - direct-story-screenshot - Someone has taken a screenshot of your direct story.
 *  - direct-story-action - Direct story badge has been updated with some action.
 *  - thread-created - New thread has been created.
 *  - thread-updated - An existing thread has been updated.
 *  - thread-notify - Someone has created ActionLog item in thread.
 *  - thread-seen - Someone has updated their last seen position.
 *  - thread-activity - Someone has created an activity (like start/stop typing) in thread.
 *  - thread-item-created - New item has been created in thread.
 *  - thread-item-updated - An existing item has been updated in thread.
 *  - thread-item-removed - An existing item has been removed from thread.
 *  - client-context-ack - Acknowledgment for client_context has been received.
 *  - unseen-count-update - Unseen count indicator has been updated.
 *  - error - An event of severity "error" occurred.
 */
class Realtime implements EventEmitterInterface
{
    use EventEmitterTrait;

    const LOGIN_INTERVAL_MIN = 1800;
    const LOGIN_INTERVAL_MAX = 3600;

    /** @var RealtimeClient\WebSocket */
    protected $_wsClient;

    /** @var RealtimeClient\Mqtt */
    protected $_mqttClient;

    /** @var Instagram */
    protected $_instagram;

    /** @var LoopInterface */
    protected $_loop;

    /** @var TimerInterface */
    protected $_reloginTimer;

    /** @var bool */
    protected $_mqttEnabled;
    /** @var bool */
    protected $_mqttReceiveEnabled;
    /** @var bool */
    protected $_mqttSendEnabled;

    /** @var bool */
    public $debug;

    /**
     * Constructor.
     *
     * @param Instagram     $instagram
     * @param LoopInterface $loop
     * @param null|bool     $debug
     */
    public function __construct(
        Instagram $instagram,
        LoopInterface $loop,
        $debug = null)
    {
        $this->_instagram = $instagram;
        $this->_loop = $loop;
        // Inherit debug flag from Instagram if not supplied.
        if ($debug === null) {
            $this->debug = $instagram->debug;
        } else {
            $this->debug = $debug;
        }
    }

    /**
     * Return main loop.
     *
     * @return LoopInterface
     */
    public function getLoop()
    {
        return $this->_loop;
    }

    /**
     * Return Instagram object.
     *
     * @return Instagram
     */
    public function getInstagram()
    {
        return $this->_instagram;
    }

    /**
     * Print debug message.
     *
     * @param string $message
     */
    public function debug(
        $message)
    {
        if (!$this->debug) {
            return;
        }

        echo date('[H:i:s] ');
        if (func_num_args() > 1) {
            call_user_func_array('printf', func_get_args());
        } else {
            echo $message;
        }
        echo PHP_EOL;
    }

    /**
     * Fires periodically to refresh session state.
     *
     * @param bool $doLogin
     */
    public function onReloginTimer(
        $doLogin = true)
    {
        if ($doLogin) {
            $this->debug('[rtc] Calling login()');
            try {
                $this->_instagram->login();
            } catch (\Exception $e) {
                $this->emit('error', [$e]);
            }
        }

        $interval = mt_rand(self::LOGIN_INTERVAL_MIN, self::LOGIN_INTERVAL_MAX);
        $this->debug('[rtc] Setting up timer for login() to %d seconds', $interval);
        $rtc = $this;
        $this->_reloginTimer = $this->_loop->addTimer($interval, function () use ($rtc) {
            $rtc->onReloginTimer();
        });
    }

    /**
     * Starts all timers and clients.
     */
    public function start()
    {
        $this->onReloginTimer(false);
        if ($this->_wsClient !== null) {
            $this->_wsClient->connect();
        }
        if ($this->_mqttClient !== null) {
            $this->_mqttClient->connect();
        }
    }

    /**
     * Stops all timers and clients.
     */
    public function stop()
    {
        if ($this->_reloginTimer) {
            $this->debug('[rtc] Login timer is cancelled');
            $this->_reloginTimer->cancel();
        }
        if ($this->_wsClient !== null) {
            $this->_wsClient->shutdown();
        }
        if ($this->_mqttClient !== null) {
            $this->_mqttClient->shutdown();
        }
    }

    /**
     * Initialize everything.
     */
    protected function _init()
    {
        $this->_instagram->login();
        // Check for MQTT experiments.
        $experiments = $this->_instagram->experiments;
        $mqttFeatures = isset($experiments['ig_android_mqtt_skywalker'])
            ? $experiments['ig_android_mqtt_skywalker'] : [];
        $this->_mqttEnabled = RealtimeClient::isFeatureEnabled($mqttFeatures, 'is_enabled');
        $this->_mqttSendEnabled = $this->_mqttEnabled && RealtimeClient::isFeatureEnabled($mqttFeatures, 'is_send_enabled');
        $this->_mqttReceiveEnabled = $this->_mqttEnabled && RealtimeClient::isFeatureEnabled($mqttFeatures, 'is_receive_enabled');
        // WebSocket Client.
        $this->debug('[rtc] starting websocket client');
        $this->_wsClient = new RealtimeClient\WebSocket('webs', $this, $this->_instagram, [
            'isMqttReceiveEnabled' => $this->_mqttReceiveEnabled,
        ]);
        // MQTT Client.
        if ($this->_mqttEnabled) {
            $mqttLiveFeatures = isset($experiments['ig_android_skywalker_live_event_start_end'])
                ? $experiments['ig_android_skywalker_live_event_start_end'] : [];
            $this->debug('[rtc] starting mqtt client');
            $this->_mqttClient = new RealtimeClient\Mqtt('mqtt', $this, $this->_instagram, [
                'isMqttReceiveEnabled' => $this->_mqttReceiveEnabled,
                'isMqttAckEnabled'     => RealtimeClient::isFeatureEnabled($mqttFeatures, 'is_ack_delivery_enabled'),
                'isMqttLiveEnabled'    => RealtimeClient::isFeatureEnabled($mqttLiveFeatures, 'is_enabled'),
                'mqttRoute'            => isset($mqttFeatures['mqtt_route']) ? $mqttFeatures['mqtt_route'] : null,
            ]);
        }
    }

    /**
     * Proxy for _init().
     *
     * @return PromiseInterface
     */
    public function init()
    {
        try {
            $this->_init();
        } catch (\Exception $e) {
            return new RejectedPromise($e);
        }

        return new FulfilledPromise($this);
    }

    /**
     * @param array $command
     *
     * @return bool
     */
    protected function _sendCommand(
        array $command)
    {
        $command = static::jsonEncode($command);
        if ($this->_mqttClient === null || !$this->_mqttSendEnabled) {
            return $this->_wsClient->sendCommand('X'.$command);
        } else {
            return $this->_mqttClient->sendCommand($command);
        }
    }

    /**
     * Marks thread item as seen.
     *
     * @param string $threadId
     * @param string $threadItemId
     *
     * @return bool
     */
    public function markDirectItemSeen(
        $threadId,
        $threadItemId)
    {
        return $this->_sendCommand([
            'thread_id' => $threadId,
            'item_id'   => $threadItemId,
            'action'    => 'mark_seen',
        ]);
    }

    /**
     * Indicate activity in thread.
     *
     * @param string $threadId
     * @param bool   $activityFlag
     *
     * @return bool|string Client context or false if sending is unavailable.
     */
    public function indicateActivityInDirectThread(
        $threadId,
        $activityFlag)
    {
        $context = Signatures::generateUUID(true);
        $result = $this->_sendCommand([
            'thread_id'       => $threadId,
            'client_context'  => $context,
            'activity_status' => $activityFlag ? '1' : '0',
            'action'          => 'indicate_activity',
        ]);

        return $result ? $context : false;
    }

    /**
     * Common method for all direct messages.
     *
     * @param array $options
     *
     * @return bool|string Client context or false if sending is unavailable.
     */
    protected function _sendItemToDirect(
        array $options)
    {
        // Init command.
        $command = [
            'action' => 'send_item',
        ];
        // Handle client_context.
        if (!isset($options['client_context'])) {
            $command['client_context'] = Signatures::generateUUID(true);
        } elseif (!Signatures::isValidUUID($options['client_context'])) {
            return false;
        } else {
            $command['client_context'] = $options['client_context'];
        }
        // Handle thread_id.
        if (!isset($options['thread_id'])) {
            return false;
        } elseif (!ctype_digit($options['thread_id']) && (!is_int($options['thread_id']) || $options['thread_id'] < 0)) {
            return false;
        } else {
            $command['thread_id'] = $options['thread_id'];
        }
        // Handle item_type specifics.
        if (!isset($options['item_type'])) {
            return false;
        }
        switch ($options['item_type']) {
            case 'text':
                if (!isset($options['text'])) {
                    return false;
                }
                $command['text'] = $options['text'];
                break;
            case 'like':
                // Nothing here.
                break;
            case 'reaction':
                // Handle item_id.
                if (!isset($options['item_id'])) {
                    return false;
                } elseif (!ctype_digit($options['item_id']) && (!is_int($options['item_id']) || $options['item_id'] < 0)) {
                    return false;
                } else {
                    $command['item_id'] = $options['item_id'];
                    $command['node_type'] = 'item';
                }
                // Handle reaction_type.
                if (!isset($options['reaction_type'])) {
                    return false;
                } elseif (!in_array($options['reaction_type'], ['like'], true)) {
                    return false;
                } else {
                    $command['reaction_type'] = $options['reaction_type'];
                }
                // Handle reaction_status.
                if (!isset($options['reaction_status'])) {
                    return false;
                } elseif (!in_array($options['reaction_status'], ['created', 'deleted'], true)) {
                    return false;
                } else {
                    $command['reaction_status'] = $options['reaction_status'];
                }
                break;
            default:
                return false;
        }
        $command['item_type'] = $options['item_type'];
        // Reorder command to simplify comparing against commands created by an application.
        $command = $this->reorderFieldsByWeight($command, $this->getSendItemWeights());

        return $this->_sendCommand($command) ? $command['client_context'] : false;
    }

    /**
     * Sends text message to a given direct thread.
     *
     * @param string $threadId Thread ID.
     * @param string $message  Text message.
     * @param array  $options  An associative array of optional parameters, including:
     *                         "client_context" - predefined UUID used to prevent double-posting;
     *
     * @return bool|string Client context or false if sending is unavailable.
     */
    public function sendTextToDirect(
        $threadId,
        $message,
        array $options = [])
    {
        return $this->_sendItemToDirect(array_merge($options, [
            'thread_id' => $threadId,
            'item_type' => 'text',
            'text'      => $message,
        ]));
    }

    /**
     * Sends like to a given direct thread.
     *
     * @param string $threadId Thread ID.
     * @param array  $options  An associative array of optional parameters, including:
     *                         "client_context" - predefined UUID used to prevent double-posting;
     *
     * @return bool|string Client context or false if sending is unavailable.
     */
    public function sendLikeToDirect(
        $threadId,
        array $options = [])
    {
        return $this->_sendItemToDirect(array_merge($options, [
            'thread_id' => $threadId,
            'item_type' => 'like',
        ]));
    }

    /**
     * Sends reaction to a given direct thread item.
     *
     * @param string $threadId     Thread ID.
     * @param string $threadItemId Thread ID.
     * @param string $reactionType One of: "like".
     * @param array  $options      An associative array of optional parameters, including:
     *                             "client_context" - predefined UUID used to prevent double-posting;
     *
     * @return bool|string Client context or false if sending is unavailable.
     */
    public function sendReactionToDirect(
        $threadId,
        $threadItemId,
        $reactionType,
        array $options = [])
    {
        return $this->_sendItemToDirect(array_merge($options, [
            'thread_id'       => $threadId,
            'item_type'       => 'reaction',
            'reaction_status' => 'created',
            'reaction_type'   => $reactionType,
            'item_id'         => $threadItemId,
        ]));
    }

    /**
     * Removes reaction to a given direct thread item.
     *
     * @param string $threadId     Thread ID.
     * @param string $threadItemId Thread ID.
     * @param string $reactionType One of: "like".
     * @param array  $options      An associative array of optional parameters, including:
     *                             "client_context" - predefined UUID used to prevent double-posting;
     *
     * @return bool|string Client context or false if sending is unavailable.
     */
    public function deleteReactionFromDirect(
        $threadId,
        $threadItemId,
        $reactionType,
        array $options = [])
    {
        return $this->_sendItemToDirect(array_merge($options, [
            'thread_id'       => $threadId,
            'item_type'       => 'reaction',
            'reaction_status' => 'deleted',
            'reaction_type'   => $reactionType,
            'item_id'         => $threadItemId,
        ]));
    }

    /**
     * Proxy for json_encode() with some necessary flags.
     *
     * @param mixed $data
     *
     * @return string
     */
    public static function jsonEncode(
        $data)
    {
        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    /**
     * Reorders an array of fields by weights to simplify debugging.
     *
     * @param array $fields
     * @param array $weights
     *
     * @return array
     */
    public function reorderFieldsByWeight(
        array $fields,
        array $weights)
    {
        uksort($fields, function ($a, $b) use ($weights) {
            $a = isset($weights[$a]) ? $weights[$a] : PHP_INT_MAX;
            $b = isset($weights[$b]) ? $weights[$b] : PHP_INT_MAX;
            if ($a < $b) {
                return -1;
            } elseif ($a > $b) {
                return 1;
            } else {
                return 0;
            }
        });

        return $fields;
    }

    /**
     * Returns an array of weights for ordering fields.
     *
     * @return array
     */
    public function getSendItemWeights()
    {
        return [
            'thread_id'       => 10,
            'item_type'       => 15,
            'text'            => 20,
            'client_context'  => 25,
            'activity_status' => 30,
            'reaction_type'   => 35,
            'reaction_status' => 40,
            'item_id'         => 45,
            'node_type'       => 50,
            'action'          => 55,
            'profile_user_id' => 60,
            'hashtag'         => 65,
            'venue_id'        => 70,
            'media_id'        => 75,
        ];
    }
}
