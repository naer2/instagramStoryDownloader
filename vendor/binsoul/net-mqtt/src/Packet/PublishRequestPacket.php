<?php

namespace BinSoul\Net\Mqtt\Packet;

use BinSoul\Net\Mqtt\PacketStream;
use BinSoul\Net\Mqtt\Packet;

/**
 * Represents the PUBLISH packet.
 */
class PublishRequestPacket extends BasePacket
{
    use IdentifiablePacket;

    /** @var string */
    private $topic;
    /** @var string */
    private $payload;

    protected static $packetType = Packet::TYPE_PUBLISH;

    public function read(PacketStream $stream)
    {
        parent::read($stream);
        $this->assertRemainingPacketLength();

        $originalPosition = $stream->getPosition();
        $this->topic = $stream->readString();
        $this->identifier = null;
        if ($this->getQosLevel() > 0) {
            $this->identifier = $stream->readWord();
        }

        $payloadLength = $this->remainingPacketLength - ($stream->getPosition() - $originalPosition);
        $this->payload = $stream->read($payloadLength);

        $this->assertValidQosLevel($this->getQosLevel());
        $this->assertValidString($this->topic);
    }

    public function write(PacketStream $stream)
    {
        $data = new PacketStream();

        $data->writeString($this->topic);
        if ($this->getQosLevel() > 0) {
            $data->writeWord($this->generateIdentifier());
        }

        $data->write($this->payload);

        $this->remainingPacketLength = $data->length();

        parent::write($stream);
        $stream->write($data->getData());
    }

    /**
     * Returns the topic.
     *
     * @return string
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * Sets the topic.
     *
     * @param string $value
     *
     * @throws \InvalidArgumentException
     */
    public function setTopic($value)
    {
        $this->assertValidString($value, false);
        if ($value === '') {
            throw new \InvalidArgumentException('The topic must not be empty.');
        }

        $this->topic = $value;
    }

    /**
     * Returns the payload.
     *
     * @return string
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * Sets the payload.
     *
     * @param string $value
     */
    public function setPayload($value)
    {
        $this->payload = $value;
    }

    /**
     * Indicates if the packet is a duplicate.
     *
     * @return bool
     */
    public function isDuplicate()
    {
        return ($this->packetFlags & 8) === 8;
    }

    /**
     * Marks the packet as duplicate.
     *
     * @param bool $value
     */
    public function setDuplicate($value)
    {
        if ($value) {
            $this->packetFlags |= 8;
        } else {
            $this->packetFlags &= ~8;
        }
    }

    /**
     * Indicates if the packet is retained.
     *
     * @return bool
     */
    public function isRetained()
    {
        return ($this->packetFlags & 1) === 1;
    }

    /**
     * Marks the packet as retained.
     *
     * @param bool $value
     */
    public function setRetained($value)
    {
        if ($value) {
            $this->packetFlags |= 1;
        } else {
            $this->packetFlags &= ~1;
        }
    }

    /**
     * Returns the quality of service level.
     *
     * @return int
     */
    public function getQosLevel()
    {
        return ($this->packetFlags & 6) >> 1;
    }

    /**
     * Sets the quality of service level.
     *
     * @param int $value
     *
     * @throws \InvalidArgumentException
     */
    public function setQosLevel($value)
    {
        $this->assertValidQosLevel($value, false);

        $this->packetFlags |= ($value & 3) << 1;
    }
}
