<?php

declare(strict_types=1);

namespace BinSoul\Net\Mqtt;

/**
 * Represents the connection of a MQTT client.
 */
interface Connection
{
    /**
     * @return int
     */
    public function getProtocol(): int;

    /**
     * @return string
     */
    public function getClientID(): string;

    /**
     * @return bool
     */
    public function isCleanSession(): bool;

    /**
     * @return string
     */
    public function getUsername(): string;

    /**
     * @return string
     */
    public function getPassword(): string;

    /**
     * @return Message|null
     */
    public function getWill();

    /**
     * @return int
     */
    public function getKeepAlive(): int;

    /**
     * Returns a new connection with the given protocol.
     *
     * @param int $protocol
     *
     * @return self
     */
    public function withProtocol(int $protocol): Connection;

    /**
     * Returns a new connection with the given client id.
     *
     * @param string $clientID
     *
     * @return self
     */
    public function withClientID(string $clientID): Connection;

    /**
     * Returns a new connection with the given credentials.
     *
     * @param string $username
     * @param string $password
     *
     * @return self
     */
    public function withCredentials(string $username, string $password): Connection;

    /**
     * Returns a new connection with the given will.
     *
     * @param Message $will
     *
     * @return self
     */
    public function withWill(Message $will): Connection;

    /**
     * Returns a new connection with the given keep alive timeout.
     *
     * @param int $timeout
     *
     * @return self
     */
    public function withKeepAlive(int $timeout): Connection;
}
