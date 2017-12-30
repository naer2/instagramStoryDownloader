<?php

namespace InstagramAPI;

use Evenement\EventEmitterInterface;
use Evenement\EventEmitterTrait;
use InstagramAPI\React\Connector;
use InstagramAPI\Realtime\Command\Direct as DirectCommand;
use InstagramAPI\Realtime\Command\IrisSubscribe;
use InstagramAPI\Realtime\Mqtt\Auth;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use React\EventLoop\LoopInterface;

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
 *  - warning - An exception of severity "warning" occurred.
 *  - error - An exception of severity "error" occurred.
 */
class Realtime implements EventEmitterInterface
{
    use EventEmitterTrait;

    /** @var Instagram */
    protected $_instagram;

    /** @var LoopInterface */
    protected $_loop;

    /** @var LoggerInterface */
    protected $_logger;

    /** @var Realtime\Mqtt */
    protected $_client;

    /**
     * Constructor.
     *
     * @param Instagram            $instagram
     * @param LoopInterface        $loop
     * @param LoggerInterface|null $logger
     *
     * @throws \RuntimeException
     */
    public function __construct(
        Instagram $instagram,
        LoopInterface $loop,
        LoggerInterface $logger = null)
    {
        if (PHP_SAPI !== 'cli') {
            throw new \RuntimeException('The Realtime client can only run from the command line.');
        }

        $this->_instagram = $instagram;
        $this->_loop = $loop;
        $this->_logger = $logger;
        if ($this->_logger === null) {
            $this->_logger = new NullLogger();
        }

        $this->_client = $this->_getClient();
    }

    /**
     * Create a new MQTT client.
     *
     * @return Realtime\Mqtt
     */
    protected function _getClient()
    {
        return new Realtime\Mqtt(
            $this,
            new Connector($this->_instagram, $this->_loop),
            new Auth($this->_instagram),
            $this->_instagram->device,
            $this->_instagram,
            $this->_loop,
            $this->_logger
        );
    }

    /**
     * Starts underlying client.
     */
    public function start()
    {
        $this->_client->start();
    }

    /**
     * Stops underlying client.
     */
    public function stop()
    {
        $this->_client->stop();
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
        try {
            $this->_client->sendCommand(new DirectCommand\MarkSeen($threadId, $threadItemId));
        } catch (\Exception $e) {
            $this->_logger->warning($e->getMessage());

            return false;
        }

        return true;
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
        try {
            $command = new DirectCommand\IndicateActivity($threadId, $activityFlag);
            $this->_client->sendCommand($command);

            return $command->getClientContext();
        } catch (\Exception $e) {
            $this->_logger->warning($e->getMessage());

            return false;
        }
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
        try {
            $command = new DirectCommand\SendText($threadId, $message, $options);
            $this->_client->sendCommand($command);

            return $command->getClientContext();
        } catch (\Exception $e) {
            $this->_logger->warning($e->getMessage());

            return false;
        }
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
        try {
            $command = new DirectCommand\SendLike($threadId, $options);
            $this->_client->sendCommand($command);

            return $command->getClientContext();
        } catch (\Exception $e) {
            $this->_logger->warning($e->getMessage());

            return false;
        }
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
        try {
            $command = new DirectCommand\SendReaction(
                $threadId,
                $threadItemId,
                $reactionType,
                DirectCommand\SendReaction::STATUS_CREATED,
                $options
            );
            $this->_client->sendCommand($command);

            return $command->getClientContext();
        } catch (\Exception $e) {
            $this->_logger->warning($e->getMessage());

            return false;
        }
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
        try {
            $command = new DirectCommand\SendReaction(
                $threadId,
                $threadItemId,
                $reactionType,
                DirectCommand\SendReaction::STATUS_DELETED,
                $options
            );
            $this->_client->sendCommand($command);

            return $command->getClientContext();
        } catch (\Exception $e) {
            $this->_logger->warning($e->getMessage());

            return false;
        }
    }

    /**
     * Receive offline messages starting from the sequence ID.
     *
     * @param int $sequenceId
     */
    public function receiveOfflineMessages(
        $sequenceId)
    {
        try {
            $this->_client->sendCommand(new IrisSubscribe($sequenceId));
        } catch (\Exception $e) {
            $this->_logger->warning($e->getMessage());
        }
    }
}
