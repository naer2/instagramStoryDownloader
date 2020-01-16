<?php

declare(strict_types=1);

namespace BinSoul\Net\Mqtt\Flow;

use BinSoul\Net\Mqtt\Packet;

/**
 * Represents a flow starting with an incoming PING packet.
 */
class IncomingPingFlow extends AbstractFlow
{
    public function getCode(): string
    {
        return 'pong';
    }

    public function start()
    {
        $this->succeed();

        return $this->generatePacket(Packet::TYPE_PINGRESP);
    }
}
