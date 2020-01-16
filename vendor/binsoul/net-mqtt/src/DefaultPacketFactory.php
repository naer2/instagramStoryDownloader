<?php

declare(strict_types=1);

namespace BinSoul\Net\Mqtt;

use BinSoul\Net\Mqtt\Exception\UnknownPacketTypeException;
use BinSoul\Net\Mqtt\Packet\ConnectRequestPacket;
use BinSoul\Net\Mqtt\Packet\ConnectResponsePacket;
use BinSoul\Net\Mqtt\Packet\DisconnectRequestPacket;
use BinSoul\Net\Mqtt\Packet\PingRequestPacket;
use BinSoul\Net\Mqtt\Packet\PingResponsePacket;
use BinSoul\Net\Mqtt\Packet\PublishAckPacket;
use BinSoul\Net\Mqtt\Packet\PublishCompletePacket;
use BinSoul\Net\Mqtt\Packet\PublishReceivedPacket;
use BinSoul\Net\Mqtt\Packet\PublishReleasePacket;
use BinSoul\Net\Mqtt\Packet\PublishRequestPacket;
use BinSoul\Net\Mqtt\Packet\SubscribeRequestPacket;
use BinSoul\Net\Mqtt\Packet\SubscribeResponsePacket;
use BinSoul\Net\Mqtt\Packet\UnsubscribeRequestPacket;
use BinSoul\Net\Mqtt\Packet\UnsubscribeResponsePacket;

/**
 * Provides a default implementation of the {@see PacketFactory} interface.
 */
class DefaultPacketFactory implements PacketFactory
{
    /**
     * Map of packet types to packet classes.
     *
     * @var string[]
     */
    private static $mapping = [
        Packet::TYPE_CONNECT => ConnectRequestPacket::class,
        Packet::TYPE_CONNACK => ConnectResponsePacket::class,
        Packet::TYPE_PUBLISH => PublishRequestPacket::class,
        Packet::TYPE_PUBACK => PublishAckPacket::class,
        Packet::TYPE_PUBREC => PublishReceivedPacket::class,
        Packet::TYPE_PUBREL => PublishReleasePacket::class,
        Packet::TYPE_PUBCOMP => PublishCompletePacket::class,
        Packet::TYPE_SUBSCRIBE => SubscribeRequestPacket::class,
        Packet::TYPE_SUBACK => SubscribeResponsePacket::class,
        Packet::TYPE_UNSUBSCRIBE => UnsubscribeRequestPacket::class,
        Packet::TYPE_UNSUBACK => UnsubscribeResponsePacket::class,
        Packet::TYPE_PINGREQ => PingRequestPacket::class,
        Packet::TYPE_PINGRESP => PingResponsePacket::class,
        Packet::TYPE_DISCONNECT => DisconnectRequestPacket::class,
    ];

    public function build(int $type): Packet
    {
        if (!isset(self::$mapping[$type])) {
            throw new UnknownPacketTypeException(sprintf('Unknown packet type %d.', $type));
        }

        $class = self::$mapping[$type];

        return new $class();
    }
}
