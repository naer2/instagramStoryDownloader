<?php

namespace BinSoul\Net\Mqtt;

/**
 * Represent a packet of the MQTT protocol.
 */
interface Packet
{
    const TYPE_CONNECT = 1;
    const TYPE_CONNACK = 2;
    const TYPE_PUBLISH = 3;
    const TYPE_PUBACK = 4;
    const TYPE_PUBREC = 5;
    const TYPE_PUBREL = 6;
    const TYPE_PUBCOMP = 7;
    const TYPE_SUBSCRIBE = 8;
    const TYPE_SUBACK = 9;
    const TYPE_UNSUBSCRIBE = 10;
    const TYPE_UNSUBACK = 11;
    const TYPE_PINGREQ = 12;
    const TYPE_PINGRESP = 13;
    const TYPE_DISCONNECT = 14;

    /**
     * Returns the type of the packet.
     *
     * @return int
     */
    public function getPacketType();

    /**
     * Reads the packet from the given stream.
     *
     * @param PacketStream $stream
     */
    public function read(PacketStream $stream);

    /**
     * Writes the packet to the given stream.
     *
     * @param PacketStream $stream
     */
    public function write(PacketStream $stream);

    /**
     * Returns the serialized form of the packet.
     *
     * @return string
     */
    public function __toString();
}
