<?php

declare(strict_types=1);

namespace BinSoul\Net\Mqtt\Flow;

use BinSoul\Net\Mqtt\ClientIdentifierGenerator;
use BinSoul\Net\Mqtt\Connection;
use BinSoul\Net\Mqtt\Packet;
use BinSoul\Net\Mqtt\Packet\ConnectRequestPacket;
use BinSoul\Net\Mqtt\Packet\ConnectResponsePacket;
use BinSoul\Net\Mqtt\PacketFactory;

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
     * @param PacketFactory             $packetFactory
     * @param Connection                $connection
     * @param ClientIdentifierGenerator $generator
     */
    public function __construct(PacketFactory $packetFactory, Connection $connection, ClientIdentifierGenerator $generator)
    {
        parent::__construct($packetFactory);

        $this->connection = $connection;

        if ($this->connection->getClientID() === '') {
            $this->connection = $this->connection->withClientID($generator->generateClientIdentifier());
        }
    }

    public function getCode(): string
    {
        return 'connect';
    }

    public function start()
    {
        /** @var ConnectRequestPacket $packet */
        $packet = $this->generatePacket(Packet::TYPE_CONNECT);
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

    public function accept(Packet $packet): bool
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

        return null;
    }
}
