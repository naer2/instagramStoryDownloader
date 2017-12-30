<?php

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

    public function getProtocol()
    {
        return $this->protocol;
    }

    public function getClientID()
    {
        return $this->clientID;
    }

    public function isCleanSession()
    {
        return $this->clean;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getWill()
    {
        return $this->will;
    }

    public function getKeepAlive()
    {
        return $this->keepAlive;
    }

    public function withProtocol($protocol)
    {
        $result = clone $this;
        $result->protocol = $protocol;

        return $result;
    }

    public function withClientID($clientID)
    {
        $result = clone $this;
        $result->clientID = $clientID;

        return $result;
    }

    public function withCredentials($username, $password)
    {
        $result = clone $this;
        $result->username = $username;
        $result->password = $password;

        return $result;
    }

    public function withWill(Message $will = null)
    {
        $result = clone $this;
        $result->will = $will;

        return $result;
    }

    public function withKeepAlive($timeout)
    {
        $result = clone $this;
        $result->keepAlive = $timeout;

        return $result;
    }
}
