<?php

/*
 * This file is part of net-mqtt.
 *
 * Copyright (c) 2015 Sebastian Mößler code@binsoul.de
 *
 * This source file is subject to the MIT license.
 */

namespace Fbns\Client\Lite;

use BinSoul\Net\Mqtt\Packet;
use BinSoul\Net\Mqtt\Packet\BasePacket;
use BinSoul\Net\Mqtt\PacketStream;

/**
 * Represents the CONNACK packet.
 */
class ConnectResponsePacket extends BasePacket
{
    /** @var string[][] */
    private static $returnCodes = [
        0 => [
            'Connection accepted',
            '',
        ],
        1 => [
            'Unacceptable protocol version',
            'The Server does not support the level of the MQTT protocol requested by the client.',
        ],
        2 => [
            'Identifier rejected',
            'The client identifier is correct UTF-8 but not allowed by the server.',
        ],
        3 => [
            'Server unavailable',
            'The network connection has been made but the MQTT service is unavailable',
        ],
        4 => [
            'Bad user name or password',
            'The data in the user name or password is malformed.',
        ],
        5 => [
            'Not authorized',
            'The client is not authorized to connect.',
        ],
    ];

    /** @var int */
    private $flags = 0;
    /** @var int */
    private $returnCode;
    /** @var string */
    private $auth;

    protected static $packetType = Packet::TYPE_CONNACK;

    public function read(PacketStream $stream)
    {
        parent::read($stream);
        $this->assertPacketFlags(0);
        $this->assertRemainingPacketLength();

        $originalPosition = $stream->getPosition();
        $this->flags = $stream->readByte();
        $this->returnCode = $stream->readByte();

        $authLength = $this->remainingPacketLength - ($stream->getPosition() - $originalPosition);
        if ($authLength) {
            $this->auth = $stream->readString();
        } else {
            $this->auth = '';
        }
    }

    public function write(PacketStream $stream)
    {
        $data = new PacketStream();

        $data->writeByte($this->flags);
        $data->writeByte($this->returnCode);

        if ($this->auth !== null && strlen($this->auth)) {
            $data->writeString($this->auth);
        }

        $this->remainingPacketLength = $data->length();

        parent::write($stream);
        $stream->write($data->getData());
    }

    /**
     * Returns the return code.
     *
     * @return int
     */
    public function getReturnCode()
    {
        return $this->returnCode;
    }

    /**
     * Indicates if the connection was successful.
     *
     * @return bool
     */
    public function isSuccess()
    {
        return $this->returnCode === 0;
    }

    /**
     * Indicates if the connection failed.
     *
     * @return bool
     */
    public function isError()
    {
        return $this->returnCode > 0;
    }

    /**
     * Returns a string representation of the returned error code.
     *
     * @return int
     */
    public function getErrorName()
    {
        if (isset(self::$returnCodes[$this->returnCode])) {
            return self::$returnCodes[$this->returnCode][0];
        }

        return 'Error '.$this->returnCode;
    }

    /**
     * @return string
     */
    public function getAuth()
    {
        return $this->auth;
    }
}
