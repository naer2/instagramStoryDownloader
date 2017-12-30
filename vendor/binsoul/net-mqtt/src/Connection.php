<?php

namespace BinSoul\Net\Mqtt;

/**
 * Represents the connection of a MQTT client.
 */
interface Connection
{
    /**
     * @return int
     */
    public function getProtocol();

    /**
     * @return string
     */
    public function getClientID();

    /**
     * @return bool
     */
    public function isCleanSession();

    /**
     * @return string
     */
    public function getUsername();

    /**
     * @return string
     */
    public function getPassword();

    /**
     * @return Message|null
     */
    public function getWill();

    /**
     * @return int
     */
    public function getKeepAlive();

    /**
     * Returns a new connection with the given protocol.
     *
     * @param int $protocol
     *
     * @return self
     */
    public function withProtocol($protocol);

    /**
     * Returns a new connection with the given client id.
     *
     * @param string $clientID
     *
     * @return self
     */
    public function withClientID($clientID);

    /**
     * Returns a new connection with the given credentials.
     *
     * @param string $username
     * @param string $password
     *
     * @return self
     */
    public function withCredentials($username, $password);

    /**
     * Returns a new connection with the given will.
     *
     * @param Message $will
     *
     * @return self
     */
    public function withWill(Message $will);

    /**
     * Returns a new connection with the given keep alive timeout.
     *
     * @param int $timeout
     *
     * @return self
     */
    public function withKeepAlive($timeout);
}
