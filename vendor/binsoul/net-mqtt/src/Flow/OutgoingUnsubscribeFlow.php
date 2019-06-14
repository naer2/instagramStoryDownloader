<?php

namespace BinSoul\Net\Mqtt\Flow;

use BinSoul\Net\Mqtt\IdentifierGenerator;
use BinSoul\Net\Mqtt\Packet;
use BinSoul\Net\Mqtt\Packet\UnsubscribeRequestPacket;
use BinSoul\Net\Mqtt\Packet\UnsubscribeResponsePacket;
use BinSoul\Net\Mqtt\Subscription;

/**
 * Represents a flow starting with an outgoing UNSUBSCRIBE packet.
 */
class OutgoingUnsubscribeFlow extends AbstractFlow
{
    /** @var int */
    private $identifier;
    /** @var Subscription[] */
    private $subscriptions;

    /**
     * Constructs an instance of this class.
     *
     * @param Subscription[]      $subscriptions
     * @param IdentifierGenerator $generator
     */
    public function __construct(array $subscriptions, IdentifierGenerator $generator)
    {
        $this->subscriptions = array_values($subscriptions);
        $this->identifier = $generator->generatePacketID();
    }

    public function getCode()
    {
        return 'unsubscribe';
    }

    public function start()
    {
        $packet = new UnsubscribeRequestPacket();
        $packet->setTopic($this->subscriptions[0]->getFilter());
        $packet->setIdentifier($this->identifier);

        return $packet;
    }

    public function accept(Packet $packet)
    {
        if ($packet->getPacketType() !== Packet::TYPE_UNSUBACK) {
            return false;
        }

        /* @var UnsubscribeResponsePacket $packet */
        return $packet->getIdentifier() === $this->identifier;
    }

    public function next(Packet $packet)
    {
        $this->succeed($this->subscriptions[0]);
    }
}
