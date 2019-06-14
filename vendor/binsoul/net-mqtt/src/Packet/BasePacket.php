<?php

namespace BinSoul\Net\Mqtt\Packet;

use BinSoul\Net\Mqtt\Exception\MalformedPacketException;
use BinSoul\Net\Mqtt\PacketStream;
use BinSoul\Net\Mqtt\Packet;

/**
 * Represents the base class for all packets.
 */
abstract class BasePacket implements Packet
{
    /**
     * Type of the packet. See {@see Packet}.
     *
     * @var int
     */
    protected static $packetType = 0;
    /**
     * Flags of the packet.
     *
     * @var int
     */
    protected $packetFlags = 0;

    /**
     * Number of bytes of a variable length packet.
     *
     * @var int
     */
    protected $remainingPacketLength = 0;

    public function __toString()
    {
        $output = new PacketStream();
        $this->write($output);

        return $output->getData();
    }

    public function read(PacketStream $stream)
    {
        $byte = $stream->readByte();

        if ($byte >> 4 !== static::$packetType) {
            throw new MalformedPacketException(
                sprintf(
                    'Expected packet type %02x but got %02x.',
                    $byte >> 4,
                    static::$packetType
                )
            );
        }

        $this->packetFlags = $byte & 0x0F;
        $this->readRemainingLength($stream);
    }

    public function write(PacketStream $stream)
    {
        $stream->writeByte(((static::$packetType & 0x0F) << 4) + ($this->packetFlags & 0x0F));
        $this->writeRemainingLength($stream);
    }

    /**
     * Reads the remaining length from the given stream.
     *
     * @param PacketStream $stream
     *
     * @throws MalformedPacketException
     */
    private function readRemainingLength(PacketStream $stream)
    {
        $this->remainingPacketLength = 0;
        $multiplier = 1;

        do {
            $encodedByte = $stream->readByte();

            $this->remainingPacketLength += ($encodedByte & 127) * $multiplier;
            $multiplier *= 128;

            if ($multiplier > 128 * 128 * 128 * 128) {
                throw new MalformedPacketException('Malformed remaining length.');
            }
        } while (($encodedByte & 128) !== 0);
    }

    /**
     * Writes the remaining length to the given stream.
     *
     * @param PacketStream $stream
     */
    private function writeRemainingLength(PacketStream $stream)
    {
        $x = $this->remainingPacketLength;
        do {
            $encodedByte = $x % 128;
            $x = (int) ($x / 128);
            if ($x > 0) {
                $encodedByte |= 128;
            }

            $stream->writeByte($encodedByte);
        } while ($x > 0);
    }

    public function getPacketType()
    {
        return static::$packetType;
    }

    /**
     * Returns the packet flags.
     *
     * @return int
     */
    public function getPacketFlags()
    {
        return $this->packetFlags;
    }

    /**
     * Returns the remaining length.
     *
     * @return int
     */
    public function getRemainingPacketLength()
    {
        return $this->remainingPacketLength;
    }

    /**
     * Asserts that the packet flags have a specific value.
     *
     * @param int  $value
     * @param bool $fromPacket
     *
     * @throws MalformedPacketException
     * @throws \InvalidArgumentException
     */
    protected function assertPacketFlags($value, $fromPacket = true)
    {
        if ($this->packetFlags !== $value) {
            $this->throwException(
                sprintf(
                    'Expected flags %02x but got %02x.',
                    $value,
                    $this->packetFlags
                ),
                $fromPacket
            );
        }
    }

    /**
     * Asserts that the remaining length is greater than zero and has a specific value.
     *
     * @param int|null $value      value to test or null if any value greater than zero is valid
     * @param bool     $fromPacket
     *
     * @throws MalformedPacketException
     * @throws \InvalidArgumentException
     */
    protected function assertRemainingPacketLength($value = null, $fromPacket = true)
    {
        if ($value === null && $this->remainingPacketLength === 0) {
            $this->throwException('Expected payload but remaining packet length is zero.', $fromPacket);
        }

        if ($value !== null && $this->remainingPacketLength !== $value) {
            $this->throwException(
                sprintf(
                    'Expected remaining packet length of %d bytes but got %d.',
                    $value,
                    $this->remainingPacketLength
                ),
                $fromPacket
            );
        }
    }

    /**
     * Asserts that the given string is a well-formed MQTT string.
     *
     * @param string $value
     * @param bool   $fromPacket
     *
     * @throws MalformedPacketException
     * @throws \InvalidArgumentException
     */
    protected function assertValidStringLength($value, $fromPacket = true)
    {
        if (strlen($value) > 0xFFFF) {
            $this->throwException(
                sprintf(
                    'The string "%s" is longer than 65535 byte.',
                    substr($value, 0, 50)
                ),
                $fromPacket
            );
        }
    }

    /**
     * Asserts that the given string is a well-formed MQTT string.
     *
     * @param string $value
     * @param bool   $fromPacket
     *
     * @throws MalformedPacketException
     * @throws \InvalidArgumentException
     */
    protected function assertValidString($value, $fromPacket = true)
    {
        $this->assertValidStringLength($value, $fromPacket);

        if (!mb_check_encoding($value, 'UTF-8')) {
            $this->throwException(
                sprintf(
                    'The string "%s" is not well-formed UTF-8.',
                    substr($value, 0, 50)
                ),
                $fromPacket
            );
        }

        if (preg_match('/[\xD8-\xDF][\x00-\xFF]|\x00\x00/x', $value)) {
            $this->throwException(
                sprintf(
                    'The string "%s" contains invalid characters.',
                    substr($value, 0, 50)
                ),
                $fromPacket
            );
        }
    }

    /**
     * Asserts that the given quality of service level is valid.
     *
     * @param int  $level
     * @param bool $fromPacket
     *
     * @throws MalformedPacketException
     * @throws \InvalidArgumentException
     */
    protected function assertValidQosLevel($level, $fromPacket = true)
    {
        if ($level < 0 || $level > 2) {
            $this->throwException(
                sprintf(
                    'Expected a quality of service level between 0 and 2 but got %d.',
                    $level
                ),
                $fromPacket
            );
        }
    }

    /**
     * Throws a MalformedPacketException for packet validation and an InvalidArgumentException otherwise.
     *
     * @param string $message
     * @param bool   $fromPacket
     *
     * @throws MalformedPacketException
     * @throws \InvalidArgumentException
     */
    protected function throwException($message, $fromPacket)
    {
        if ($fromPacket) {
            throw new MalformedPacketException($message);
        }

        throw new \InvalidArgumentException($message);
    }
}
