<?php

namespace BinSoul\Net\Mqtt;

/**
 * Represents a message.
 */
interface Message
{
    /**
     * Returns the topic.
     *
     * @return string
     */
    public function getTopic();

    /**
     * Returns the payload.
     *
     * @return string
     */
    public function getPayload();

    /**
     * Returns the quality of service level.
     *
     * @return int
     */
    public function getQosLevel();

    /**
     * Indicates if the message is a duplicate.
     *
     * @return bool
     */
    public function isDuplicate();

    /**
     * Indicates if the message is retained.
     *
     * @return bool
     */
    public function isRetained();

    /**
     * Returns a new message with the given topic.
     *
     * @param string $topic
     *
     * @return self
     */
    public function withTopic($topic);

    /**
     * Returns a new message with the given payload.
     *
     * @param string $payload
     *
     * @return self
     */
    public function withPayload($payload);

    /**
     * Returns a new message with the given quality of service level.
     *
     * @param int $level
     *
     * @return self
     */
    public function withQosLevel($level);

    /**
     * Returns a new message flagged as retained.
     *
     * @return self
     */
    public function retain();

    /**
     * Returns a new message flagged as not retained.
     *
     * @return self
     */
    public function release();

    /**
     * Returns a new message flagged as duplicate.
     *
     * @return self
     */
    public function duplicate();

    /**
     * Returns a new message flagged as original.
     *
     * @return self
     */
    public function original();
}
