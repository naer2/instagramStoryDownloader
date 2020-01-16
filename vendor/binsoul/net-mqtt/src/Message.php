<?php

declare(strict_types=1);

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
    public function getTopic(): string;

    /**
     * Returns the payload.
     *
     * @return string
     */
    public function getPayload(): string;

    /**
     * Returns the quality of service level.
     *
     * @return int
     */
    public function getQosLevel(): int;

    /**
     * Indicates if the message is a duplicate.
     *
     * @return bool
     */
    public function isDuplicate(): bool;

    /**
     * Indicates if the message is retained.
     *
     * @return bool
     */
    public function isRetained(): bool;

    /**
     * Returns a new message with the given topic.
     *
     * @param string $topic
     *
     * @return self
     */
    public function withTopic(string $topic): Message;

    /**
     * Returns a new message with the given payload.
     *
     * @param string $payload
     *
     * @return self
     */
    public function withPayload(string $payload): Message;

    /**
     * Returns a new message with the given quality of service level.
     *
     * @param int $level
     *
     * @return self
     */
    public function withQosLevel(int $level): Message;

    /**
     * Returns a new message flagged as retained.
     *
     * @return self
     */
    public function retain(): Message;

    /**
     * Returns a new message flagged as not retained.
     *
     * @return self
     */
    public function release(): Message;

    /**
     * Returns a new message flagged as duplicate.
     *
     * @return self
     */
    public function duplicate(): Message;

    /**
     * Returns a new message flagged as original.
     *
     * @return self
     */
    public function original(): Message;
}
