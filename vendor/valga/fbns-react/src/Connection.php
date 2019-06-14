<?php

namespace Fbns\Client;

use Fbns\Client\Thrift\Compact;
use Fbns\Client\Thrift\Writer;

class Connection
{
    const FBNS_CLIENT_CAPABILITIES = 439;
    const FBNS_ENDPOINT_CAPABILITIES = 128;
    const FBNS_APP_ID = '567310203415052';
    const FBNS_CLIENT_STACK = 3;
    const FBNS_PUBLISH_FORMAT = 1;

    const CLIENT_ID = 1;
    const CLIENT_INFO = 4;
    const PASSWORD = 5;

    const USER_ID = 1;
    const USER_AGENT = 2;
    const CLIENT_CAPABILITIES = 3;
    const ENDPOINT_CAPABILITIES = 4;
    const PUBLISH_FORMAT = 5;
    const NO_AUTOMATIC_FOREGROUND = 6;
    const MAKE_USER_AVAILABLE_IN_FOREGROUND = 7;
    const DEVICE_ID = 8;
    const IS_INITIALLY_FOREGROUND = 9;
    const NETWORK_TYPE = 10;
    const NETWORK_SUBTYPE = 11;
    const CLIENT_MQTT_SESSION_ID = 12;
    const SUBSCRIBE_TOPICS = 14;
    const CLIENT_TYPE = 15;
    const APP_ID = 16;
    const DEVICE_SECRET = 20;
    const CLIENT_STACK = 21;

    /** @var AuthInterface */
    private $auth;

    /** @var string */
    private $userAgent;
    /** @var int */
    private $clientCapabilities;
    /** @var int */
    private $endpointCapabilities;
    /** @var int */
    private $publishFormat;
    /** @var bool */
    private $noAutomaticForeground;
    /** @var bool */
    private $makeUserAvailableInForeground;
    /** @var bool */
    private $isInitiallyForeground;
    /** @var int */
    private $networkType;
    /** @var int */
    private $networkSubtype;
    /** @var int */
    private $clientMqttSessionId;
    /** @var int[] */
    private $subscribeTopics;
    /** @var int */
    private $appId;
    /** @var int */
    private $clientStack;

    /**
     * Connection constructor.
     *
     * @param AuthInterface $auth
     * @param string        $userAgent
     */
    public function __construct(AuthInterface $auth, $userAgent)
    {
        $this->auth = $auth;
        $this->userAgent = $userAgent;

        $this->clientCapabilities = self::FBNS_CLIENT_CAPABILITIES;
        $this->endpointCapabilities = self::FBNS_ENDPOINT_CAPABILITIES;
        $this->publishFormat = self::FBNS_PUBLISH_FORMAT;
        $this->noAutomaticForeground = true;
        $this->makeUserAvailableInForeground = false;
        $this->isInitiallyForeground = false;
        $this->networkType = 1;
        $this->networkSubtype = 0;
        $this->subscribeTopics = [(int) Lite::MESSAGE_TOPIC_ID, (int) Lite::REG_RESP_TOPIC_ID];
        $this->appId = self::FBNS_APP_ID;
        $this->clientStack = self::FBNS_CLIENT_STACK;
    }

    /**
     * @return string
     */
    public function toThrift()
    {
        $writer = new Writer();

        $writer->writeString(self::CLIENT_ID, $this->auth->getClientId());

        $writer->writeStruct(self::CLIENT_INFO);
        $writer->writeInt64(self::USER_ID, $this->auth->getUserId());
        $writer->writeString(self::USER_AGENT, $this->userAgent);
        $writer->writeInt64(self::CLIENT_CAPABILITIES, $this->clientCapabilities);
        $writer->writeInt64(self::ENDPOINT_CAPABILITIES, $this->endpointCapabilities);
        $writer->writeInt32(self::PUBLISH_FORMAT, $this->publishFormat);
        $writer->writeBool(self::NO_AUTOMATIC_FOREGROUND, $this->noAutomaticForeground);
        $writer->writeBool(self::MAKE_USER_AVAILABLE_IN_FOREGROUND, $this->makeUserAvailableInForeground);
        $writer->writeString(self::DEVICE_ID, $this->auth->getDeviceId());
        $writer->writeBool(self::IS_INITIALLY_FOREGROUND, $this->isInitiallyForeground);
        $writer->writeInt32(self::NETWORK_TYPE, $this->networkType);
        $writer->writeInt32(self::NETWORK_SUBTYPE, $this->networkSubtype);
        if ($this->clientMqttSessionId === null) {
            $sessionId = (int) ((microtime(true) - strtotime('Last Monday')) * 1000);
        } else {
            $sessionId = $this->clientMqttSessionId;
        }
        $writer->writeInt64(self::CLIENT_MQTT_SESSION_ID, $sessionId);
        $writer->writeList(self::SUBSCRIBE_TOPICS, Compact::TYPE_I32, $this->subscribeTopics);
        $writer->writeString(self::CLIENT_TYPE, $this->auth->getClientType());
        $writer->writeInt64(self::APP_ID, $this->appId);
        $writer->writeString(self::DEVICE_SECRET, $this->auth->getDeviceSecret());
        $writer->writeInt8(self::CLIENT_STACK, $this->clientStack);
        $writer->writeStop();

        $writer->writeString(self::PASSWORD, $this->auth->getPassword());
        $writer->writeStop();

        return (string) $writer;
    }

    /**
     * @return string
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * @param string $userAgent
     */
    public function setUserAgent($userAgent)
    {
        $this->userAgent = $userAgent;
    }

    /**
     * @return int
     */
    public function getClientCapabilities()
    {
        return $this->clientCapabilities;
    }

    /**
     * @param int $clientCapabilities
     */
    public function setClientCapabilities($clientCapabilities)
    {
        $this->clientCapabilities = $clientCapabilities;
    }

    /**
     * @return int
     */
    public function getEndpointCapabilities()
    {
        return $this->endpointCapabilities;
    }

    /**
     * @param int $endpointCapabilities
     */
    public function setEndpointCapabilities($endpointCapabilities)
    {
        $this->endpointCapabilities = $endpointCapabilities;
    }

    /**
     * @return bool
     */
    public function isNoAutomaticForeground()
    {
        return $this->noAutomaticForeground;
    }

    /**
     * @param bool $noAutomaticForeground
     */
    public function setNoAutomaticForeground($noAutomaticForeground)
    {
        $this->noAutomaticForeground = $noAutomaticForeground;
    }

    /**
     * @return bool
     */
    public function isMakeUserAvailableInForeground()
    {
        return $this->makeUserAvailableInForeground;
    }

    /**
     * @param bool $makeUserAvailableInForeground
     */
    public function setMakeUserAvailableInForeground($makeUserAvailableInForeground)
    {
        $this->makeUserAvailableInForeground = $makeUserAvailableInForeground;
    }

    /**
     * @return bool
     */
    public function isInitiallyForeground()
    {
        return $this->isInitiallyForeground;
    }

    /**
     * @param bool $isInitiallyForeground
     */
    public function setIsInitiallyForeground($isInitiallyForeground)
    {
        $this->isInitiallyForeground = $isInitiallyForeground;
    }

    /**
     * @return int
     */
    public function getNetworkType()
    {
        return $this->networkType;
    }

    /**
     * @param int $networkType
     */
    public function setNetworkType($networkType)
    {
        $this->networkType = $networkType;
    }

    /**
     * @return int
     */
    public function getNetworkSubtype()
    {
        return $this->networkSubtype;
    }

    /**
     * @param int $networkSubtype
     */
    public function setNetworkSubtype($networkSubtype)
    {
        $this->networkSubtype = $networkSubtype;
    }

    /**
     * @return int
     */
    public function getClientMqttSessionId()
    {
        return $this->clientMqttSessionId;
    }

    /**
     * @param int $clientMqttSessionId
     */
    public function setClientMqttSessionId($clientMqttSessionId)
    {
        $this->clientMqttSessionId = $clientMqttSessionId;
    }

    /**
     * @return int[]
     */
    public function getSubscribeTopics()
    {
        return $this->subscribeTopics;
    }

    /**
     * @param int[] $subscribeTopics
     */
    public function setSubscribeTopics($subscribeTopics)
    {
        $this->subscribeTopics = $subscribeTopics;
    }

    /**
     * @return int
     */
    public function getAppId()
    {
        return $this->appId;
    }

    /**
     * @param int $appId
     */
    public function setAppId($appId)
    {
        $this->appId = $appId;
    }

    /**
     * @return int
     */
    public function getClientStack()
    {
        return $this->clientStack;
    }

    /**
     * @param int $clientStack
     */
    public function setClientStack($clientStack)
    {
        $this->clientStack = $clientStack;
    }

    /**
     * @return AuthInterface
     */
    public function getAuth()
    {
        return $this->auth;
    }

    /**
     * @param AuthInterface $auth
     */
    public function setAuth(AuthInterface $auth)
    {
        $this->auth = $auth;
    }
}
