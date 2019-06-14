<?php

namespace BinSoul\Net\Mqtt\Packet;

use BinSoul\Net\Mqtt\Packet;

/**
 * Represents the PUBACK packet.
 */
class PublishAckPacket extends IdentifierOnlyPacket
{
    protected static $packetType = Packet::TYPE_PUBACK;
}
