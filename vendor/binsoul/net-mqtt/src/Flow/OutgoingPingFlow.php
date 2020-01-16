<?php

declare(strict_types=1);

namespace BinSoul\Net\Mqtt\Flow;

use BinSoul\Net\Mqtt\Packet;

/**
 * Represents a flow starting with an outgoing PING packet.
 */
class OutgoingPingFlow extends AbstractFlow
{
    public function getCode(): string
    {
        return 'ping';
    }

    public function start()
    {
        return $this->generatePacket(Packet::TYPE_PINGREQ);
    }

    public function accept(Packet $packet): bool
    {
        return $packet->getPacketType() === Packet::TYPE_PINGRESP;
    }

    public function next(Packet $packet)
    {
        $this->succeed();

        return null;
    }
}
