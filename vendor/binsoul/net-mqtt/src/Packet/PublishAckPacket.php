<?php

declare(strict_types=1);

namespace BinSoul\Net\Mqtt\Packet;

use BinSoul\Net\Mqtt\Packet;

/**
 * Represents the PUBACK packet.
 */
class PublishAckPacket extends IdentifierOnlyPacket
{
    protected static $packetType = Packet::TYPE_PUBACK;
}
