<?php

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
    public function read($count)
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

        $chunk = substr($this->data, $this->position, $count);
        if ($chunk === false) {
            $chunk = '';
        }

        $readBytes = strlen($chunk);
        $this->position += $readBytes;

        return $chunk;
    }

    /**
     * Returns a single byte.
     *
     * @return int
     */
    public function readByte()
    {
        return ord($this->read(1));
    }

    /**
     * Returns a single word.
     *
     * @return int
     */
    public function readWord()
    {
        return ($this->readByte() << 8) + $this->readByte();
    }

    /**
     * Returns a length prefixed string.
     *
     * @return string
     */
    public function readString()
    {
        $length = $this->readWord();

        return $this->read($length);
    }

    /**
     * Appends the given value.
     *
     * @param string $value
     */
    public function write($value)
    {
        $this->data .= $value;
    }

    /**
     * Appends a single byte.
     *
     * @param int $value
     */
    public function writeByte($value)
    {
        $this->write(chr($value));
    }

    /**
     * Appends a single word.
     *
     * @param int $value
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
    public function length()
    {
        return strlen($this->data);
    }

    /**
     * Returns the number of bytes until the end of the stream.
     *
     * @return int
     */
    public function getRemainingBytes()
    {
        return $this->length() - $this->position;
    }

    /**
     * Returns the whole content of the stream.
     *
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Changes the internal position of the stream relative to the current position.
     *
     * @param int $offset
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
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Sets the internal position of the stream.
     *
     * @param int $value
     */
    public function setPosition($value)
    {
        $this->position = $value;
    }

    /**
     * Removes all bytes from the beginning to the current position.
     */
    public function cut()
    {
        $this->data = substr($this->data, $this->position);
        if ($this->data === false) {
            $this->data = '';
        }

        $this->position = 0;
    }
}
