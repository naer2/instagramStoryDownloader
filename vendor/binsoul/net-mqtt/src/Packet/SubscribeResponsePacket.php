<?php

namespace BinSoul\Net\Mqtt\Packet;

use BinSoul\Net\Mqtt\Exception\MalformedPacketException;
use BinSoul\Net\Mqtt\PacketStream;
use BinSoul\Net\Mqtt\Packet;

/**
 * Represents the SUBACK packet.
 */
class SubscribeResponsePacket extends BasePacket
{
    use IdentifiablePacket;

    private static $qosLevels = [
        0 => ['Maximum QoS 0'],
        1 => ['Maximum QoS 1'],
        2 => ['Maximum QoS 2'],
        128 => ['Failure'],
    ];

    /** @var int[] */
    private $returnCodes;

    protected static $packetType = Packet::TYPE_SUBACK;

    public function read(PacketStream $stream)
    {
        parent::read($stream);
        $this->assertPacketFlags(0);
        $this->assertRemainingPacketLength();

        $this->identifier = $stream->readWord();

        $returnCodeLength = $this->remainingPacketLength - 2;
        for ($n = 0; $n < $returnCodeLength; ++$n) {
            $returnCode = $stream->readByte();
            $this->assertValidReturnCode($returnCode);

            $this->returnCodes[] = $returnCode;
        }
    }

    public function write(PacketStream $stream)
    {
        $data = new PacketStream();

        $data->writeWord($this->generateIdentifier());
        foreach ($this->returnCodes as $returnCode) {
            $data->writeByte($returnCode);
        }

        $this->remainingPacketLength = $data->length();

        parent::write($stream);
        $stream->write($data->getData());
    }

    /**
     * Indicates if the given return code is an error.
     *
     * @param int $returnCode
     *
     * @return bool
     */
    public function isError($returnCode)
    {
        return $returnCode === 128;
    }

    /**
     * Indicates if the given return code is an error.
     *
     * @param int $returnCode
     *
     * @return bool
     */
    public function getReturnCodeName($returnCode)
    {
        if (isset(self::$qosLevels[$returnCode])) {
            return self::$qosLevels[$returnCode][0];
        }

        return 'Unknown '.$returnCode;
    }

    /**
     * Returns the return codes.
     *
     * @return int[]
     */
    public function getReturnCodes()
    {
        return $this->returnCodes;
    }

    /**
     * Sets the return codes.
     *
     * @param int[] $value
     *
     * @throws \InvalidArgumentException
     */
    public function setReturnCodes(array $value)
    {
        foreach ($value as $returnCode) {
            $this->assertValidReturnCode($returnCode, false);
        }

        $this->returnCodes = $value;
    }

    /**
     * Asserts that a return code is valid.
     *
     * @param int  $returnCode
     * @param bool $fromPacket
     *
     * @throws MalformedPacketException
     * @throws \InvalidArgumentException
     */
    private function assertValidReturnCode($returnCode, $fromPacket = true)
    {
        if (!in_array($returnCode, [0, 1, 2, 128])) {
            $this->throwException(
                sprintf('Malformed return code %02x.', $returnCode),
                $fromPacket
            );
        }
    }
}
