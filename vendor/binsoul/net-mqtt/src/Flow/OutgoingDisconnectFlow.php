<?php

namespace BinSoul\Net\Mqtt\Flow;

use BinSoul\Net\Mqtt\Connection;
use BinSoul\Net\Mqtt\Packet\DisconnectRequestPacket;

/**
 * Represents a flow starting with an outgoing DISCONNECT packet.
 */
class OutgoingDisconnectFlow extends AbstractFlow
{
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
        return 'disconnect';
    }

    public function start()
    {
        $this->succeed($this->connection);

        return new DisconnectRequestPacket();
    }
}
