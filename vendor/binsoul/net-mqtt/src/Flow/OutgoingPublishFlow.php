<?php

declare(strict_types=1);

namespace BinSoul\Net\Mqtt\Flow;

use BinSoul\Net\Mqtt\Message;
use BinSoul\Net\Mqtt\Packet;
use BinSoul\Net\Mqtt\Packet\PublishAckPacket;
use BinSoul\Net\Mqtt\Packet\PublishCompletePacket;
use BinSoul\Net\Mqtt\Packet\PublishReceivedPacket;
use BinSoul\Net\Mqtt\Packet\PublishReleasePacket;
use BinSoul\Net\Mqtt\Packet\PublishRequestPacket;
use BinSoul\Net\Mqtt\PacketFactory;
use BinSoul\Net\Mqtt\PacketIdentifierGenerator;

/**
 * Represents a flow starting with an outgoing PUBLISH packet.
 */
class OutgoingPublishFlow extends AbstractFlow
{
    /** @var int|null */
    private $identifier;
    /** @var Message */
    private $message;
    /** @var bool */
    private $receivedPubRec = false;

    /**
     * Constructs an instance of this class.
     *
     * @param PacketFactory             $packetFactory
     * @param Message                   $message
     * @param PacketIdentifierGenerator $generator
     */
    public function __construct(PacketFactory $packetFactory, Message $message, PacketIdentifierGenerator $generator)
    {
        parent::__construct($packetFactory);

        $this->message = $message;
        if ($this->message->getQosLevel() > 0) {
            $this->identifier = $generator->generatePacketIdentifier();
        }
    }

    public function getCode(): string
    {
        return 'publish';
    }

    public function start()
    {
        /** @var PublishRequestPacket $packet */
        $packet = $this->generatePacket(Packet::TYPE_PUBLISH);
        $packet->setTopic($this->message->getTopic());
        $packet->setPayload($this->message->getPayload());
        $packet->setRetained($this->message->isRetained());
        $packet->setDuplicate($this->message->isDuplicate());
        $packet->setQosLevel($this->message->getQosLevel());

        if ($this->message->getQosLevel() === 0) {
            $this->succeed($this->message);
        } else {
            $packet->setIdentifier($this->identifier);
        }

        return $packet;
    }

    public function accept(Packet $packet): bool
    {
        if ($this->message->getQosLevel() === 0) {
            return false;
        }

        $packetType = $packet->getPacketType();

        if ($packetType === Packet::TYPE_PUBACK && $this->message->getQosLevel() === 1) {
            /** @var PublishAckPacket $packet */
            return $packet->getIdentifier() === $this->identifier;
        }

        if ($this->message->getQosLevel() === 2) {
            if ($packetType === Packet::TYPE_PUBREC) {
                /** @var PublishReceivedPacket $packet */
                return $packet->getIdentifier() === $this->identifier;
            }

            if ($this->receivedPubRec && $packetType === Packet::TYPE_PUBCOMP) {
                /** @var PublishCompletePacket $packet */
                return $packet->getIdentifier() === $this->identifier;
            }
        }

        return false;
    }

    public function next(Packet $packet)
    {
        $packetType = $packet->getPacketType();

        if ($packetType === Packet::TYPE_PUBACK || $packetType === Packet::TYPE_PUBCOMP) {
            $this->succeed($this->message);
        } elseif ($packetType === Packet::TYPE_PUBREC) {
            $this->receivedPubRec = true;

            /** @var PublishReleasePacket $response */
            $response = $this->generatePacket(Packet::TYPE_PUBREL);
            $response->setIdentifier($this->identifier);

            return $response;
        }

        return null;
    }
}
