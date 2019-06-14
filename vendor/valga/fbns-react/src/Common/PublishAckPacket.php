<?php

/*
 * This file is part of net-mqtt.
 *
 * Copyright (c) 2015 Sebastian Mößler code@binsoul.de
 *
 * This source file is subject to the MIT license.
 */

namespace Fbns\Client\Common;

use BinSoul\Net\Mqtt\Packet\BasePacket;
use BinSoul\Net\Mqtt\Packet\PublishAckPacket as BasePublishAckPacket;
use BinSoul\Net\Mqtt\PacketStream;

/**
 * Represents the PUBACK packet.
 */
class PublishAckPacket extends BasePublishAckPacket
{
    public function read(PacketStream $stream)
    {
        BasePacket::read($stream);
        //$this->assertPacketFlags($this->getExpectedPacketFlags());
        $this->assertRemainingPacketLength(2);

        $this->identifier = $stream->readWord();
    }
}
