<?php

namespace BinSoul\Net\Mqtt;

/**
 * Generates identifiers.
 */
interface IdentifierGenerator
{
    /**
     * Generates a packet identifier between 1 and 0xFFFF.
     *
     * @return int
     */
    public function generatePacketID();

    /**
     * Generates a client identifier of up to 23 bytes.
     *
     * @return string
     */
    public function generateClientID();
}
