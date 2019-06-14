<?php

namespace Fbns\Client;

use BinSoul\Net\Mqtt\DefaultMessage;
use BinSoul\Net\Mqtt\Message;
use Evenement\EventEmitterInterface;
use Evenement\EventEmitterTrait;
use Fbns\Client\Lite\ConnectResponsePacket;
use Fbns\Client\Lite\OutgoingConnectFlow;
use Fbns\Client\Lite\ReactMqttClient;
use Fbns\Client\Lite\StreamParser;
use Fbns\Client\Message\Push;
use Fbns\Client\Message\Register;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use React\EventLoop\LoopInterface;
use React\EventLoop\Timer\TimerInterface;
use React\Promise\Deferred;
use React\Promise\FulfilledPromise;
use React\Promise\PromiseInterface;
use React\Socket\Connector;
use React\Socket\ConnectorInterface;
use React\Socket\SecureConnector;

class Lite implements EventEmitterInterface
{
    use EventEmitterTrait;

    const QOS_LEVEL = 1;

    const MESSAGE_TOPIC = '/fbns_msg';
    const MESSAGE_TOPIC_ID = '76';

    const REG_REQ_TOPIC = '/fbns_reg_req';
    const REG_REQ_TOPIC_ID = '79';

    const REG_RESP_TOPIC = '/fbns_reg_resp';
    const REG_RESP_TOPIC_ID = '80';

    const ID_TO_TOPIC_ENUM = [
        self::MESSAGE_TOPIC_ID => self::MESSAGE_TOPIC,
        self::REG_REQ_TOPIC_ID => self::REG_REQ_TOPIC,
        self::REG_RESP_TOPIC_ID => self::REG_RESP_TOPIC,
    ];

    const TOPIC_TO_ID_ENUM = [
        self::MESSAGE_TOPIC => self::MESSAGE_TOPIC_ID,
        self::REG_REQ_TOPIC => self::REG_REQ_TOPIC_ID,
        self::REG_RESP_TOPIC => self::REG_RESP_TOPIC_ID,
    ];

    /**
     * @var LoopInterface
     */
    private $loop;

    /**
     * @var ConnectorInterface
     */
    private $connector;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var ReactMqttClient
     */
    private $client;

    /**
     * @var TimerInterface
     */
    private $keepaliveTimer;

    /**
     * Constructor.
     *
     * @param LoopInterface           $loop
     * @param ConnectorInterface|null $connector
     * @param LoggerInterface|null    $logger
     */
    public function __construct(LoopInterface $loop, ConnectorInterface $connector = null, LoggerInterface $logger = null)
    {
        $this->loop = $loop;
        if ($connector === null) {
            $this->connector = new SecureConnector(new Connector($loop), $loop);
        } else {
            $this->connector = $connector;
        }
        if ($logger !== null) {
            $this->logger = $logger;
        } else {
            $this->logger = new NullLogger();
        }
        $this->client = new ReactMqttClient($this->connector, $this->loop, null, new StreamParser());

        $this->client
            ->on('open', function () {
                $this->logger->info('Connection has been established.');
            })
            ->on('close', function () {
                $this->logger->info('Network connection has been closed.');
                $this->cancelKeepaliveTimer();
                $this->emit('disconnect', [$this]);
            })
            ->on('warning', function (\Exception $e) {
                $this->logger->warning($e->getMessage());
            })
            ->on('error', function (\Exception $e) {
                $this->logger->error($e->getMessage());
                $this->emit('error', [$e]);
            })
            ->on('connect', function (ConnectResponsePacket $responsePacket) {
                $this->logger->info('Connected to a broker.');
                $this->setKeepaliveTimer();
                $this->emit('connect', [$responsePacket]);
            })
            ->on('disconnect', function () {
                $this->logger->info('Disconnected from the broker.');
            })
            ->on('message', function (Message $message) {
                $this->setKeepaliveTimer();
                $this->onMessage($message);
            })
            ->on('publish', function () {
                $this->logger->info('Publish flow has been completed.');
                $this->setKeepaliveTimer();
            })
            ->on('ping', function () {
                $this->logger->info('Ping flow has been completed.');
                $this->setKeepaliveTimer();
            });
    }

    private function cancelKeepaliveTimer()
    {
        if ($this->keepaliveTimer !== null) {
            if ($this->keepaliveTimer->isActive()) {
                $this->logger->info('Existing keepalive timer has been canceled.');
                $this->keepaliveTimer->cancel();
            }
            $this->keepaliveTimer = null;
        }
    }

    private function onKeepalive()
    {
        $this->logger->info('Keepalive timer has been fired.');
        $this->cancelKeepaliveTimer();
        $this->disconnect();
    }

    private function setKeepaliveTimer()
    {
        $this->cancelKeepaliveTimer();
        $keepaliveInterval = OutgoingConnectFlow::KEEPALIVE;
        $this->logger->info(sprintf('Setting up keepalive timer to %d seconds', $keepaliveInterval));
        $this->keepaliveTimer = $this->loop->addTimer($keepaliveInterval, function () {
            $this->onKeepalive();
        });
    }

    /**
     * @param string $payload
     */
    private function onRegister($payload)
    {
        try {
            $message = new Register($payload);
        } catch (\Exception $e) {
            $this->logger->warning(sprintf('Failed to decode register message: %s', $e->getMessage()), [$payload]);

            return;
        }

        $this->emit('register', [$message]);
    }

    /**
     * @param string $payload
     */
    private function onPush($payload)
    {
        try {
            $message = new Push($payload);
        } catch (\Exception $e) {
            $this->logger->warning(sprintf('Failed to decode push message: %s', $e->getMessage()), [$payload]);

            return;
        }

        $this->emit('push', [$message]);
    }

    /**
     * @param Message $message
     */
    private function onMessage(Message $message)
    {
        $payload = @zlib_decode($message->getPayload());
        if ($payload === false) {
            $this->logger->warning('Failed to inflate a payload.');

            return;
        }

        $topic = $this->unmapTopic($message->getTopic());
        $this->logger->info(sprintf('Received a message from topic "%s".', $topic), [$payload]);

        switch ($topic) {
            case self::MESSAGE_TOPIC:
                $this->onPush($payload);
                break;
            case self::REG_RESP_TOPIC:
                $this->onRegister($payload);
                break;
            default:
                $this->logger->warning(sprintf('Received a message from unknown topic "%s".', $topic), [$payload]);
        }
    }

    /**
     * Establishes a connection to the FBNS server.
     *
     * @param string     $host
     * @param int        $port
     * @param Connection $connection
     * @param int        $timeout
     *
     * @return PromiseInterface
     */
    private function establishConnection($host, $port, Connection $connection, $timeout)
    {
        $this->logger->info(sprintf('Connecting to %s:%d...', $host, $port));

        return $this->client->connect($host, $port, $connection, $timeout);
    }

    /**
     * Connects to a FBNS server.
     *
     * @param string     $host
     * @param int        $port
     * @param Connection $connection
     * @param int        $timeout
     *
     * @return PromiseInterface
     */
    public function connect($host, $port, Connection $connection, $timeout = 5)
    {
        $deferred = new Deferred();
        $this->disconnect()
            ->then(function () use ($deferred, $host, $port, $connection, $timeout) {
                $this->establishConnection($host, $port, $connection, $timeout)
                    ->then(function () use ($deferred) {
                        $deferred->resolve($this);
                    })
                    ->otherwise(function (\Exception $error) use ($deferred) {
                        $deferred->reject($error);
                    });
            })
            ->otherwise(function () use ($deferred) {
                $deferred->reject($this);
            });

        return $deferred->promise();
    }

    /**
     * @return PromiseInterface
     */
    public function disconnect()
    {
        if ($this->client->isConnected()) {
            $deferred = new Deferred();
            $this->client->disconnect()
                ->then(function () use ($deferred) {
                    $deferred->resolve($this);
                })
                ->otherwise(function () use ($deferred) {
                    $deferred->reject($this);
                });

            return $deferred->promise();
        } else {
            return new FulfilledPromise($this);
        }
    }

    /**
     * Maps human readable topic to its ID.
     *
     * @param string $topic
     *
     * @return string
     */
    private function mapTopic($topic)
    {
        if (array_key_exists($topic, self::TOPIC_TO_ID_ENUM)) {
            $result = self::TOPIC_TO_ID_ENUM[$topic];
            $this->logger->debug(sprintf('Topic "%s" has been mapped to "%s".', $topic, $result));
        } else {
            $result = $topic;
            $this->logger->debug(sprintf('Topic "%s" does not exist in enum.', $topic));
        }

        return $result;
    }

    /**
     * Maps topic ID to human readable name.
     *
     * @param string $topic
     *
     * @return string
     */
    private function unmapTopic($topic)
    {
        if (array_key_exists($topic, self::ID_TO_TOPIC_ENUM)) {
            $result = self::ID_TO_TOPIC_ENUM[$topic];
            $this->logger->debug(sprintf('Topic ID "%s" has been unmapped to "%s".', $topic, $result));
        } else {
            $result = $topic;
            $this->logger->debug(sprintf('Topic ID "%s" does not exist in enum.', $topic));
        }

        return $result;
    }

    /**
     * Publish a message to a topic.
     *
     * @param string $topic
     * @param string $message
     * @param int    $qosLevel
     *
     * @return \React\Promise\ExtendedPromiseInterface
     */
    private function publish($topic, $message, $qosLevel)
    {
        $this->logger->info(sprintf('Sending message to topic "%s".', $topic), [$message]);
        $topic = $this->mapTopic($topic);
        $payload = zlib_encode($message, ZLIB_ENCODING_DEFLATE, 9);

        return $this->client->publish(new DefaultMessage($topic, $payload, $qosLevel));
    }

    /**
     * Registers an application.
     *
     * @param string     $packageName
     * @param string|int $appId
     *
     * @return PromiseInterface
     */
    public function register($packageName, $appId)
    {
        $this->logger->info(sprintf('Registering application "%s" (%s).', $packageName, $appId));
        $message = json_encode([
            'pkg_name' => (string) $packageName,
            'appid' => (string) $appId,
        ]);

        return $this->publish(self::REG_REQ_TOPIC, $message, self::QOS_LEVEL);
    }

    /**
     * Checks whether underlying client is connected.
     *
     * @return bool
     */
    public function isConnected()
    {
        return $this->client->isConnected();
    }
}
