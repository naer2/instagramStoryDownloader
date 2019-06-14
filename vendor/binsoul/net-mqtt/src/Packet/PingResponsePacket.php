<?php

namespace BinSoul\Net\Mqtt\Packet;

use BinSoul\Net\Mqtt\PacketStream;
use BinSoul\Net\Mqtt\Packet;

/**
 * Represents the PINGRESP packet.
 */
class PingResponsePacket extends BasePacket
{
    protected static $packetType = Packet::TYPE_PINGRESP;

    public function read(PacketStream $stream)
    {
        parent::read($stream);

        $this->assertPacketFlags(0);
        $this->assertRemainingPacketLength(0);
    }
}
