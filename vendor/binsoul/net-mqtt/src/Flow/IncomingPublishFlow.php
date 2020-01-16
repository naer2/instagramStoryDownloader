<?php

declare(strict_types=1);

namespace BinSoul\Net\Mqtt\Flow;

use BinSoul\Net\Mqtt\Message;
use BinSoul\Net\Mqtt\Packet;
use BinSoul\Net\Mqtt\Packet\PublishAckPacket;
use BinSoul\Net\Mqtt\Packet\PublishCompletePacket;
use BinSoul\Net\Mqtt\Packet\PublishReceivedPacket;
use BinSoul\Net\Mqtt\Packet\PublishReleasePacket;
use BinSoul\Net\Mqtt\PacketFactory;

/**
 * Represents a flow starting with an incoming PUBLISH packet.
 */
class IncomingPublishFlow extends AbstractFlow
{
    /** @var int|null */
    private $identifier;
    /** @var Message */
    private $message;

    /**
     * Constructs an instance of this class.
     *
     * @param PacketFactory $packetFactory
     * @param Message       $message
     * @param int|null      $identifier
     */
    public function __construct(PacketFactory $packetFactory, Message $message, $identifier = null)
    {
        parent::__construct($packetFactory);

        $this->message = $message;
        $this->identifier = $identifier;
    }

    public function getCode(): string
    {
        return 'message';
    }

    public function start()
    {
        $packet = null;
        $emit = true;
        if ($this->message->getQosLevel() === 1) {
            $packet = $this->generatePacket(Packet::TYPE_PUBACK);
        } elseif ($this->message->getQosLevel() === 2) {
            $packet = $this->generatePacket(Packet::TYPE_PUBREC);
            $emit = false;
        }

        if ($packet !== null) {
            /** @var PublishAckPacket|PublishReceivedPacket $packet */
            $packet->setIdentifier($this->identifier);
        }

        if ($emit) {
            $this->succeed($this->message);
        }

        return $packet;
    }

    public function accept(Packet $packet): bool
    {
        if ($this->message->getQosLevel() !== 2 || $packet->getPacketType() !== Packet::TYPE_PUBREL) {
            return false;
        }

        /** @var PublishReleasePacket $packet */
        return $packet->getIdentifier() === $this->identifier;
    }

    public function next(Packet $packet)
    {
        $this->succeed($this->message);

        /** @var PublishCompletePacket $response */
        $response = $this->generatePacket(Packet::TYPE_PUBCOMP);
        $response->setIdentifier($this->identifier);

        return $response;
    }
}
