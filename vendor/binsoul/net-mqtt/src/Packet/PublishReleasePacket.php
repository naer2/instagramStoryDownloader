<?php

namespace BinSoul\Net\Mqtt\Packet;

use BinSoul\Net\Mqtt\Packet;

/**
 * Represents the PUBREL packet.
 */
class PublishReleasePacket extends IdentifierOnlyPacket
{
    protected static $packetType = Packet::TYPE_PUBREL;
    protected $packetFlags = 2;

    protected function getExpectedPacketFlags()
    {
        return 2;
    }
}
