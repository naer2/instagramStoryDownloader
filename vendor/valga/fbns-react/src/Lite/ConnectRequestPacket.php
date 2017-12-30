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
 * Represents the CONNECT packet.
 */
class ConnectRequestPacket extends BasePacket
{
    /** @var int */
    private $protocolLevel = 3;
    /** @var string */
    private $protocolName = 'MQTToT';
    /** @var int */
    private $flags = 194;
    /** @var int */
    private $keepAlive = 900;
    /** @var string */
    private $payload;

    protected static $packetType = Packet::TYPE_CONNECT;

    public function read(PacketStream $stream)
    {
        parent::read($stream);
        $this->assertPacketFlags(0);
        $this->assertRemainingPacketLength();

        $originalPosition = $stream->getPosition();
        $this->protocolName = $stream->readString();
        $this->protocolLevel = $stream->readByte();
        $this->flags = $stream->readByte();
        $this->keepAlive = $stream->readWord();

        $payloadLength = $this->remainingPacketLength - ($stream->getPosition() - $originalPosition);
        $this->payload = $stream->read($payloadLength);
    }

    public function write(PacketStream $stream)
    {
        $data = new PacketStream();

        $data->writeString($this->protocolName);
        $data->writeByte($this->protocolLevel);
        $data->writeByte($this->flags);
        $data->writeWord($this->keepAlive);
        $data->write($this->payload);

        $this->remainingPacketLength = $data->length();

        parent::write($stream);
        $stream->write($data->getData());
    }

    /**
     * Returns the protocol level.
     *
     * @return int
     */
    public function getProtocolLevel()
    {
        return $this->protocolLevel;
    }

    /**
     * Sets the protocol level.
     *
     * @param int $value
     *
     * @throws \InvalidArgumentException
     */
    public function setProtocolLevel($value)
    {
        if ($value != 3) {
            throw new \InvalidArgumentException(sprintf('Unknown protocol level %d.', $value));
        }

        $this->protocolLevel = $value;
    }

    /**
     * Returns the payload.
     *
     * @return string
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * Sets the payload.
     *
     * @param string $value
     */
    public function setPayload($value)
    {
        $this->payload = $value;
    }

    /**
     * Returns the flags.
     *
     * @return int
     */
    public function getFlags()
    {
        return $this->flags;
    }

    /**
     * Sets the flags.
     *
     * @param int $value
     *
     * @throws \InvalidArgumentException
     */
    public function setFlags($value)
    {
        if ($value > 255) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Expected a flags lower than 255 but got %d.',
                    $value
                )
            );
        }

        $this->flags = $value;
    }

    /**
     * Returns the keep alive time in seconds.
     *
     * @return int
     */
    public function getKeepAlive()
    {
        return $this->keepAlive;
    }

    /**
     * Sets the keep alive time in seconds.
     *
     * @param int $value
     *
     * @throws \InvalidArgumentException
     */
    public function setKeepAlive($value)
    {
        if ($value > 65535) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Expected a keep alive time lower than 65535 but got %d.',
                    $value
                )
            );
        }

        $this->keepAlive = $value;
    }

    /**
     * Returns the protocol name.
     *
     * @return string
     */
    public function getProtocolName()
    {
        return $this->protocolName;
    }

    /**
     * Sets the protocol name.
     *
     * @param string $value
     *
     * @throws \InvalidArgumentException
     */
    public function setProtocolName($value)
    {
        $this->assertValidStringLength($value, false);

        $this->protocolName = $value;
    }
}
