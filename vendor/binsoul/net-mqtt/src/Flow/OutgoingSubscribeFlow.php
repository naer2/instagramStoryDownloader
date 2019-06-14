<?php

namespace BinSoul\Net\Mqtt\Flow;

use BinSoul\Net\Mqtt\IdentifierGenerator;
use BinSoul\Net\Mqtt\Packet;
use BinSoul\Net\Mqtt\Packet\SubscribeRequestPacket;
use BinSoul\Net\Mqtt\Packet\SubscribeResponsePacket;
use BinSoul\Net\Mqtt\Subscription;

/**
 * Represents a flow starting with an outgoing SUBSCRIBE packet.
 */
class OutgoingSubscribeFlow extends AbstractFlow
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
        return 'subscribe';
    }

    public function start()
    {
        $packet = new SubscribeRequestPacket();
        $packet->setTopic($this->subscriptions[0]->getFilter());
        $packet->setQosLevel($this->subscriptions[0]->getQosLevel());
        $packet->setIdentifier($this->identifier);

        return $packet;
    }

    public function accept(Packet $packet)
    {
        if ($packet->getPacketType() !== Packet::TYPE_SUBACK) {
            return false;
        }

        /* @var SubscribeResponsePacket $packet */
        return $packet->getIdentifier() === $this->identifier;
    }

    public function next(Packet $packet)
    {
        /* @var SubscribeResponsePacket $packet */
        $returnCodes = $packet->getReturnCodes();
        if (count($returnCodes) !== count($this->subscriptions)) {
            throw new \LogicException(
                sprintf(
                    'SUBACK: Expected %d return codes but got %d.',
                    count($this->subscriptions),
                    count($returnCodes)
                )
            );
        }

        foreach ($returnCodes as $index => $code) {
            if ($packet->isError($code)) {
                $this->fail(sprintf('Failed to subscribe to "%s".', $this->subscriptions[$index]->getFilter()));

                return;
            }
        }

        $this->succeed($this->subscriptions[0]);
    }
}
