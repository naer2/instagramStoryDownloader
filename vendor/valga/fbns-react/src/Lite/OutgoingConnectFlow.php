<?php

/*
 * This file is part of net-mqtt.
 *
 * Copyright (c) 2015 Sebastian Mößler code@binsoul.de
 *
 * This source file is subject to the MIT license.
 */

namespace Fbns\Client\Lite;

use BinSoul\Net\Mqtt\Flow\AbstractFlow;
use BinSoul\Net\Mqtt\Packet;
use BinSoul\Net\Mqtt\Packet\ConnectResponsePacket;
use Fbns\Client\Connection;

/**
 * Represents a flow starting with an outgoing CONNECT packet.
 */
class OutgoingConnectFlow extends AbstractFlow
{
    const PROTOCOL_LEVEL = 3;

    const PROTOCOL_NAME = 'MQTToT';

    const KEEPALIVE = 900;
    const KEEPALIVE_TIMEOUT = 60;

    /** @var Connection */
    private $connection;

    /**
     * Constructs an instance of this class.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getCode()
    {
        return 'connect';
    }

    public function start()
    {
        $packet = new ConnectRequestPacket();
        $packet->setProtocolLevel(self::PROTOCOL_LEVEL);
        $packet->setProtocolName(self::PROTOCOL_NAME);
        $packet->setKeepAlive(self::KEEPALIVE);
        $packet->setFlags(194);
        $packet->setPayload(zlib_encode($this->connection->toThrift(), ZLIB_ENCODING_DEFLATE, 9));

        return $packet;
    }

    public function accept(Packet $packet)
    {
        return $packet->getPacketType() === Packet::TYPE_CONNACK;
    }

    public function next(Packet $packet)
    {
        /** @var ConnectResponsePacket $packet */
        if ($packet->isSuccess()) {
            $this->succeed($packet);
        } else {
            $this->fail($packet->getErrorName());
        }
    }
}
