<?php

namespace BinSoul\Net\Mqtt\Flow;

use BinSoul\Net\Mqtt\Connection;
use BinSoul\Net\Mqtt\IdentifierGenerator;
use BinSoul\Net\Mqtt\Packet;
use BinSoul\Net\Mqtt\Packet\ConnectRequestPacket;
use BinSoul\Net\Mqtt\Packet\ConnectResponsePacket;

/**
 * Represents a flow starting with an outgoing CONNECT packet.
 */
class OutgoingConnectFlow extends AbstractFlow
{
    /** @var Connection */
    private $connection;

    /**
     * Constructs an instance of this class.
     *
     * @param Connection          $connection
     * @param IdentifierGenerator $generator
     */
    public function __construct(Connection $connection, IdentifierGenerator $generator)
    {
        $this->connection = $connection;

        if ($this->connection->getClientID() === '') {
            $this->connection = $this->connection->withClientID($generator->generateClientID());
        }
    }

    public function getCode()
    {
        return 'connect';
    }

    public function start()
    {
        $packet = new ConnectRequestPacket();
        $packet->setProtocolLevel($this->connection->getProtocol());
        $packet->setKeepAlive($this->connection->getKeepAlive());
        $packet->setClientID($this->connection->getClientID());
        $packet->setCleanSession($this->connection->isCleanSession());
        $packet->setUsername($this->connection->getUsername());
        $packet->setPassword($this->connection->getPassword());
        $will = $this->connection->getWill();
        if ($will !== null && $will->getTopic() !== '' && $will->getPayload() !== '') {
            $packet->setWill($will->getTopic(), $will->getPayload(), $will->getQosLevel(), $will->isRetained());
        }

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
            $this->succeed($this->connection);
        } else {
            $this->fail($packet->getErrorName());
        }
    }
}
