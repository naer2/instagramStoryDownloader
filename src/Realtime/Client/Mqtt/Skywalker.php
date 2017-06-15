<?php

namespace InstagramAPI\Realtime\Client\Mqtt;

/**
 * @see https://thrift.apache.org/
 */
class Skywalker
{
    const TYPE_DIRECT = 1;
    const TYPE_LIVE = 2;
    const TYPE_LIVEWITH = 3;

    const FIELD_TYPE = 1;
    const FIELD_PAYLOAD = 2;

    const COMPACT_STOP = 0x00;
    const COMPACT_I32 = 0x05;
    const COMPACT_BINARY = 0x08;

    /** @var int */
    protected $_position;
    /** @var int */
    protected $_length;
    /** @var string */
    protected $_buffer;

    /** @var int */
    protected $_type;
    /** @var string */
    protected $_payload;

    /**
     * Constructor.
     *
     * @param string $string
     */
    public function __construct(
        $string = '')
    {
        $this->_buffer = $string;
        $this->_position = 0;
        $this->_length = strlen($string);
        $this->_parse();
    }

    /**
     * Parse buffer.
     */
    protected function _parse()
    {
        $field = 0;
        while ($this->_position < $this->_length) {
            $typeAndDelta = ord($this->_buffer[$this->_position++]);
            $delta = $typeAndDelta >> 4;
            if ($delta == 0) {
                $field = $this->_fromZigZag($this->_readVarint());
            } else {
                $field += $delta;
            }
            $type = $typeAndDelta & 0x0f;
            if ($type == self::COMPACT_STOP) {
                return;
            }
            if ($field == self::FIELD_TYPE && $type == self::COMPACT_I32) {
                $this->_type = $this->_fromZigZag($this->_readVarint());
            } elseif ($field == self::FIELD_PAYLOAD && $type == self::COMPACT_BINARY) {
                $length = $this->_readVarint();
                $this->_payload = substr($this->_buffer, $this->_position, $length);
                $this->_position += $length;
            }
        }
    }

    /**
     * @return int
     */
    protected function _readVarint()
    {
        $shift = 0;
        $result = 0;
        while ($this->_position < $this->_length) {
            $byte = ord($this->_buffer[$this->_position++]);
            $result |= ($byte & 0x7f) << $shift;
            if (($byte >> 7) === 0) {
                break;
            }
            $shift += 7;
        }

        return $result;
    }

    /**
     * @param int $n
     *
     * @return int
     */
    protected function _fromZigZag(
        $n)
    {
        return ($n >> 1) ^ -($n & 1);
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * @return string
     */
    public function getPayload()
    {
        return $this->_payload;
    }
}
