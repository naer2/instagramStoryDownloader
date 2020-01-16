<?php

declare(strict_types=1);

namespace BinSoul\Net\Mqtt;

use BinSoul\Net\Mqtt\Exception\EndOfStreamException;
use BinSoul\Net\Mqtt\Exception\MalformedPacketException;
use BinSoul\Net\Mqtt\Exception\UnknownPacketTypeException;

/**
 * Provides methods to parse a stream of bytes into packets.
 */
class StreamParser
{
    /** @var PacketStream */
    private $buffer;
    /** @var PacketFactory */
    private $factory;
    /** @var callable */
    private $errorCallback;

    /**
     * Constructs an instance of this class.
     *
     * @param PacketFactory|null $packetFactory
     */
    public function __construct(PacketFactory $packetFactory = null)
    {
        $this->buffer = new PacketStream();
        $this->factory = $packetFactory ?? new DefaultPacketFactory();
    }

    /**
     * Registers an error callback.
     *
     * @param callable $callback
     *
     * @return void
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
    public function push($data): array
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
     *
     * @return void
     */
    private function handleError($exception)
    {
        if ($this->errorCallback !== null) {
            $callback = $this->errorCallback;
            $callback($exception);
        }
    }
}
