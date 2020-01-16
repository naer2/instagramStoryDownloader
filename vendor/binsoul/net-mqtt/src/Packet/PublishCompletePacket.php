<?php

declare(strict_types=1);

namespace BinSoul\Net\Mqtt\Packet;

use BinSoul\Net\Mqtt\Packet;

/**
 * Represents the PUBCOMP packet.
 */
class PublishCompletePacket extends IdentifierOnlyPacket
{
    protected static $packetType = Packet::TYPE_PUBCOMP;
}
