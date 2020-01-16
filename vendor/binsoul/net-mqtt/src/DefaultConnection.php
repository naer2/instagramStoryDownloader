<?php

declare(strict_types=1);

namespace BinSoul\Net\Mqtt;

/**
 * Provides a default implementation of the {@see Connection} interface.
 */
class DefaultConnection implements Connection
{
    /** @var string */
    private $username;
    /** @var string */
    private $password;
    /** @var Message|null */
    private $will;
    /** @var string */
    private $clientID;
    /** @var int */
    private $keepAlive;
    /** @var int */
    private $protocol;
    /** @var bool */
    private $clean;

    /**
     * Constructs an instance of this class.
     *
     * @param string       $username
     * @param string       $password
     * @param Message|null $will
     * @param string       $clientID
     * @param int          $keepAlive
     * @param int          $protocol
     * @param bool         $clean
     */
    public function __construct(
        $username = '',
        $password = '',
        Message $will = null,
        $clientID = '',
        $keepAlive = 60,
        $protocol = 4,
        $clean = true
    ) {
        $this->username = $username;
        $this->password = $password;
        $this->will = $will;
        $this->clientID = $clientID;
        $this->keepAlive = $keepAlive;
        $this->protocol = $protocol;
        $this->clean = $clean;
    }

    public function getProtocol(): int
    {
        return $this->protocol;
    }

    public function getClientID(): string
    {
        return $this->clientID;
    }

    public function isCleanSession(): bool
    {
        return $this->clean;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getWill()
    {
        return $this->will;
    }

    public function getKeepAlive(): int
    {
        return $this->keepAlive;
    }

    public function withProtocol(int $protocol): Connection
    {
        $result = clone $this;
        $result->protocol = $protocol;

        return $result;
    }

    public function withClientID(string $clientID): Connection
    {
        $result = clone $this;
        $result->clientID = $clientID;

        return $result;
    }

    public function withCredentials(string $username, string $password): Connection
    {
        $result = clone $this;
        $result->username = $username;
        $result->password = $password;

        return $result;
    }

    public function withWill(Message $will = null): Connection
    {
        $result = clone $this;
        $result->will = $will;

        return $result;
    }

    public function withKeepAlive(int $timeout): Connection
    {
        $result = clone $this;
        $result->keepAlive = $timeout;

        return $result;
    }
}
