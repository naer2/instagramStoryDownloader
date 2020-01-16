<?php

declare(strict_types=1);

namespace BinSoul\Net\Mqtt\Packet;

use BinSoul\Net\Mqtt\Packet;

/**
 * Represents the PUBREL packet.
 */
class PublishReleasePacket extends IdentifierOnlyPacket
{
    protected static $packetType = Packet::TYPE_PUBREL;
    protected $packetFlags = 2;

    protected function getExpectedPacketFlags(): int
    {
        return 2;
    }
}
