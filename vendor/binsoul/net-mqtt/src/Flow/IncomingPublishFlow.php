<?php

namespace BinSoul\Net\Mqtt\Flow;

use BinSoul\Net\Mqtt\Message;
use BinSoul\Net\Mqtt\Packet;
use BinSoul\Net\Mqtt\Packet\PublishAckPacket;
use BinSoul\Net\Mqtt\Packet\PublishCompletePacket;
use BinSoul\Net\Mqtt\Packet\PublishReceivedPacket;
use BinSoul\Net\Mqtt\Packet\PublishReleasePacket;

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
     * @param Message  $message
     * @param int|null $identifier
     */
    public function __construct(Message $message, $identifier = null)
    {
        $this->message = $message;
        $this->identifier = $identifier;
    }

    public function getCode()
    {
        return 'message';
    }

    public function start()
    {
        $packet = null;
        $emit = true;
        if ($this->message->getQosLevel() === 1) {
            $packet = new PublishAckPacket();
        } elseif ($this->message->getQosLevel() === 2) {
            $packet = new PublishReceivedPacket();
            $emit = false;
        }

        if ($packet !== null) {
            $packet->setIdentifier($this->identifier);
        }

        if ($emit) {
            $this->succeed($this->message);
        }

        return $packet;
    }

    public function accept(Packet $packet)
    {
        if ($this->message->getQosLevel() !== 2 || $packet->getPacketType() !== Packet::TYPE_PUBREL) {
            return false;
        }

        /* @var PublishReleasePacket $packet */
        return $packet->getIdentifier() === $this->identifier;
    }

    public function next(Packet $packet)
    {
        $this->succeed($this->message);

        $response = new PublishCompletePacket();
        $response->setIdentifier($this->identifier);

        return $response;
    }
}
