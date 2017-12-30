<?php

/*
 * This file is part of net-mqtt.
 *
 * Copyright (c) 2015 Sebastian Mößler code@binsoul.de
 *
 * This source file is subject to the MIT license.
 */

namespace Fbns\Client\Lite;

use BinSoul\Net\Mqtt\Exception\EndOfStreamException;
use BinSoul\Net\Mqtt\Exception\MalformedPacketException;
use BinSoul\Net\Mqtt\Exception\UnknownPacketTypeException;
use BinSoul\Net\Mqtt\Packet;
use BinSoul\Net\Mqtt\PacketStream;
use BinSoul\Net\Mqtt\StreamParser as BaseStreamParser;

/**
 * Provides methods to parse a stream of bytes into packets.
 */
class StreamParser extends BaseStreamParser
{
    /** @var PacketStream */
    private $buffer;
    /** @var PacketFactory */
    private $factory;
    /** @var callable */
    private $errorCallback;

    /**
     * Constructs an instance of this class.
     */
    public function __construct()
    {
        parent::__construct();
        $this->buffer = new PacketStream();
        $this->factory = new PacketFactory();
    }

    /**
     * Registers an error callback.
     *
     * @param callable $callback
     */
    public function onError($callback)
    {
        $this->errorCallback = $callback;
    }

    /**
     * Appends the given data to the internal buffer and parses it.
     *
     * @param string $data
     *
     * @return Packet[]
     */
    public function push($data)
    {
        $this->buffer->write($data);

        $result = [];
        while ($this->buffer->getRemainingBytes() > 0) {
            $type = $this->buffer->readByte() >> 4;
            try {
                $packet = $this->factory->build($type);
            } catch (UnknownPacketTypeException $e) {
                $this->handleError($e);
                continue;
            }

            $this->buffer->seek(-1);
            $position = $this->buffer->getPosition();
            try {
                $packet->read($this->buffer);
                $result[] = $packet;
                $this->buffer->cut();
            } catch (EndOfStreamException $e) {
                $this->buffer->setPosition($position);
                break;
            } catch (MalformedPacketException $e) {
                $this->handleError($e);
            }
        }

        return $result;
    }

    /**
     * Executes the registered error callback.
     *
     * @param \Throwable $exception
     */
    private function handleError($exception)
    {
        if ($this->errorCallback !== null) {
            $callback = $this->errorCallback;
            $callback($exception);
        }
    }
}
