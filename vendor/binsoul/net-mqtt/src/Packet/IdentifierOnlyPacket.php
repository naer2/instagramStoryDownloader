<?php

namespace BinSoul\Net\Mqtt\Packet;

use BinSoul\Net\Mqtt\PacketStream;

/**
 * Provides a base class for PUB* packets.
 */
abstract class IdentifierOnlyPacket extends BasePacket
{
    use IdentifiablePacket;

    protected $remainingPacketLength = 2;

    public function read(PacketStream $stream)
    {
        parent::read($stream);
        $this->assertPacketFlags($this->getExpectedPacketFlags());
        $this->assertRemainingPacketLength(2);

        $this->identifier = $stream->readWord();
    }

    public function write(PacketStream $stream)
    {
        $this->remainingPacketLength = 2;
        parent::write($stream);

        $stream->writeWord($this->generateIdentifier());
    }

    /**
     * Returns the expected packet flags.
     *
     * @return int
     */
    protected function getExpectedPacketFlags()
    {
        return 0;
    }
}
