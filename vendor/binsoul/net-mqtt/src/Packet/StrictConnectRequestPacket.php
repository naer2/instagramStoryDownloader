<?php

namespace BinSoul\Net\Mqtt\Packet;

use BinSoul\Net\Mqtt\Exception\MalformedPacketException;
use BinSoul\Net\Mqtt\PacketStream;

/**
 * Represents the CONNECT packet with strict rules for client ids.
 */
class StrictConnectRequestPacket extends ConnectRequestPacket
{
    public function read(PacketStream $stream)
    {
        parent::read($stream);

        $this->assertValidClientID($this->clientID, true);
    }

    /**
     * Sets the client id.
     *
     * @param string $value
     *
     * @throws \InvalidArgumentException
     */
    public function setClientID($value)
    {
        $this->assertValidClientID($value, false);

        $this->clientID = $value;
    }

    /**
     * Asserts that a client id is shorter than 24 bytes and only contains characters 0-9, a-z or A-Z.
     *
     * @param string $value
     * @param bool   $fromPacket
     *
     * @throws MalformedPacketException
     * @throws \InvalidArgumentException
     */
    private function assertValidClientID($value, $fromPacket)
    {

        if (strlen($value) > 23) {
            $this->throwException(
                sprintf(
                    'Expected client id shorter than 24 bytes but got "%s".',
                    $value
                ),
                $fromPacket
            );
        }

        if ($value !== '' && !ctype_alnum($value)) {
            $this->throwException(
                sprintf(
                    'Expected a client id containing characters 0-9, a-z or A-Z but got "%s".',
                    $value
                ),
                $fromPacket
            );
        }
    }
}
