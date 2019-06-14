<?php

namespace BinSoul\Net\Mqtt\Flow;

use BinSoul\Net\Mqtt\IdentifierGenerator;
use BinSoul\Net\Mqtt\Message;
use BinSoul\Net\Mqtt\Packet;
use BinSoul\Net\Mqtt\Packet\PublishAckPacket;
use BinSoul\Net\Mqtt\Packet\PublishCompletePacket;
use BinSoul\Net\Mqtt\Packet\PublishReceivedPacket;
use BinSoul\Net\Mqtt\Packet\PublishReleasePacket;
use BinSoul\Net\Mqtt\Packet\PublishRequestPacket;

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
     * @param Message             $message
     * @param IdentifierGenerator $generator
     */
    public function __construct(Message $message, IdentifierGenerator $generator)
    {
        $this->message = $message;
        if ($this->message->getQosLevel() > 0) {
            $this->identifier = $generator->generatePacketID();
        }
    }

    public function getCode()
    {
        return 'publish';
    }

    public function start()
    {
        $packet = new PublishRequestPacket();
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

    public function accept(Packet $packet)
    {
        if ($this->message->getQosLevel() === 0) {
            return false;
        }

        $packetType = $packet->getPacketType();

        if ($packetType === Packet::TYPE_PUBACK && $this->message->getQosLevel() === 1) {
            /* @var PublishAckPacket $packet */
            return $packet->getIdentifier() === $this->identifier;
        } elseif ($this->message->getQosLevel() === 2) {
            if ($packetType === Packet::TYPE_PUBREC) {
                /* @var PublishReceivedPacket $packet */
                return $packet->getIdentifier() === $this->identifier;
            } elseif ($this->receivedPubRec && $packetType === Packet::TYPE_PUBCOMP) {
                /* @var PublishCompletePacket $packet */
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

            $response = new PublishReleasePacket();
            $response->setIdentifier($this->identifier);

            return $response;
        }
    }
}
