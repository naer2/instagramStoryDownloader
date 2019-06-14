<?php

namespace BinSoul\Net\Mqtt;

/**
 * Provides a default implementation of the {@see Message} interface.
 */
class DefaultMessage implements Message
{
    /** @var string */
    private $topic;
    /** @var string */
    private $payload;
    /** @var bool */
    private $isRetained;
    /** @var bool */
    private $isDuplicate = false;
    /** @var int */
    private $qosLevel;

    /**
     * Constructs an instance of this class.
     *
     * @param string $topic
     * @param string $payload
     * @param int    $qosLevel
     * @param bool   $retain
     * @param bool   $isDuplicate
     */
    public function __construct($topic, $payload = '', $qosLevel = 0, $retain = false, $isDuplicate = false)
    {
        $this->topic = $topic;
        $this->payload = $payload;
        $this->isRetained = $retain;
        $this->qosLevel = $qosLevel;
        $this->isDuplicate = $isDuplicate;
    }

    public function getTopic()
    {
        return $this->topic;
    }

    public function getPayload()
    {
        return $this->payload;
    }

    public function getQosLevel()
    {
        return $this->qosLevel;
    }

    public function isDuplicate()
    {
        return $this->isDuplicate;
    }

    public function isRetained()
    {
        return $this->isRetained;
    }

    public function withTopic($topic)
    {
        $result = clone $this;
        $result->topic = $topic;

        return $result;
    }

    public function withPayload($payload)
    {
        $result = clone $this;
        $result->payload = $payload;

        return $result;
    }

    public function withQosLevel($level)
    {
        $result = clone $this;
        $result->qosLevel = $level;

        return $result;
    }

    public function retain()
    {
        $result = clone $this;
        $result->isRetained = true;

        return $result;
    }

    public function release()
    {
        $result = clone $this;
        $result->isRetained = false;

        return $result;
    }

    public function duplicate()
    {
        $result = clone $this;
        $result->isDuplicate = true;

        return $result;
    }

    public function original()
    {
        $result = clone $this;
        $result->isDuplicate = false;

        return $result;
    }
}
