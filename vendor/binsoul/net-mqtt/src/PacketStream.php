<?php

declare(strict_types=1);

namespace BinSoul\Net\Mqtt;

use BinSoul\Net\Mqtt\Exception\EndOfStreamException;

/**
 * Provides methods to operate on a stream of bytes.
 */
class PacketStream
{
    /** @var string */
    private $data;
    /** @var int */
    private $position;

    /**
     * Constructs an instance of this class.
     *
     * @param string $data initial data of the stream
     */
    public function __construct($data = '')
    {
        $this->data = $data;
        $this->position = 0;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->data;
    }

    /**
     * Returns the desired number of bytes.
     *
     * @param int $count
     *
     * @throws EndOfStreamException
     *
     * @return string
     */
    public function read($count): string
    {
        $contentLength = strlen($this->data);
        if ($this->position > $contentLength || $count > $contentLength - $this->position) {
            throw new EndOfStreamException(
                sprintf(
                    'End of stream reached when trying to read %d bytes. content length=%d, position=%d',
                    $count,
                    $contentLength,
                    $this->position
                )
            );
        }

        $chunk = (string) substr($this->data, $this->position, $count);
        $readBytes = strlen($chunk);
        $this->position += $readBytes;

        return $chunk;
    }

    /**
     * Returns a single byte.
     *
     * @return int
     */
    public function readByte(): int
    {
        return ord($this->read(1));
    }

    /**
     * Returns a single word.
     *
     * @return int
     */
    public function readWord(): int
    {
        return ($this->readByte() << 8) + $this->readByte();
    }

    /**
     * Returns a length prefixed string.
     *
     * @return string
     */
    public function readString(): string
    {
        $length = $this->readWord();

        return $this->read($length);
    }

    /**
     * Appends the given value.
     *
     * @param string $value
     *
     * @return void
     */
    public function write($value)
    {
        $this->data .= $value;
    }

    /**
     * Appends a single byte.
     *
     * @param int $value
     *
     * @return void
     */
    public function writeByte($value)
    {
        $this->write(chr($value));
    }

    /**
     * Appends a single word.
     *
     * @param int $value
     *
     * @return void
     */
    public function writeWord($value)
    {
        $this->write(chr(($value & 0xFFFF) >> 8));
        $this->write(chr($value & 0xFF));
    }

    /**
     * Appends a length prefixed string.
     *
     * @param string $string
     *
     * @return void
     */
    public function writeString($string)
    {
        $this->writeWord(strlen($string));
        $this->write($string);
    }

    /**
     * Returns the length of the stream.
     *
     * @return int
     */
    public function length(): int
    {
        return strlen($this->data);
    }

    /**
     * Returns the number of bytes until the end of the stream.
     *
     * @return int
     */
    public function getRemainingBytes(): int
    {
        return $this->length() - $this->position;
    }

    /**
     * Returns the whole content of the stream.
     *
     * @return string
     */
    public function getData(): string
    {
        return $this->data;
    }

    /**
     * Changes the internal position of the stream relative to the current position.
     *
     * @param int $offset
     *
     * @return void
     */
    public function seek($offset)
    {
        $this->position += $offset;
    }

    /**
     * Returns the internal position of the stream.
     *
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * Sets the internal position of the stream.
     *
     * @param int $value
     *
     * @return void
     */
    public function setPosition($value)
    {
        $this->position = $value;
    }

    /**
     * Removes all bytes from the beginning to the current position.
     *
     * @return void
     */
    public function cut()
    {
        $this->data = (string) substr($this->data, $this->position);
        $this->position = 0;
    }
}
