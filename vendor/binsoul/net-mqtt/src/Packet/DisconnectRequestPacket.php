<?php

declare(strict_types=1);

namespace BinSoul\Net\Mqtt\Packet;

use BinSoul\Net\Mqtt\Packet;
use BinSoul\Net\Mqtt\PacketStream;

/**
 * Represents the DISCONNECT packet.
 */
class DisconnectRequestPacket extends BasePacket
{
    protected static $packetType = Packet::TYPE_DISCONNECT;

    public function read(PacketStream $stream)
    {
        parent::read($stream);

        $this->assertPacketFlags(0);
        $this->assertRemainingPacketLength(0);
    }
}
