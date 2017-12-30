<?php

namespace BinSoul\Net\Mqtt\Flow;

use BinSoul\Net\Mqtt\Packet\PingResponsePacket;

/**
 * Represents a flow starting with an incoming PING packet.
 */
class IncomingPingFlow extends AbstractFlow
{
    public function getCode()
    {
        return 'pong';
    }

    public function start()
    {
        $this->succeed();

        return new PingResponsePacket();
    }
}
