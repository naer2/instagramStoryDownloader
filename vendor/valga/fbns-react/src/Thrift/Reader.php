<?php

namespace Fbns\Client\Thrift;

/**
 * WARNING: This implementation is not complete.
 *
 * @see https://thrift.apache.org/
 */
class Reader
{
    /**
     * @var int[]
     */
    private $stack;

    /**
     * @var int
     */
    private $field;

    /**
     * @var string
     */
    private $buffer;

    /**
     * @var int
     */
    private $length;

    /**
     * @var int
     */
    private $position;

    /**
     * @var callable|null
     */
    private $handler;

    /**
     * Reader constructor.
     *
     * @param string        $buffer
     * @param callable|null $handler
     */
    public function __construct($buffer = '', callable $handler = null)
    {
        if (PHP_INT_SIZE === 4 && !extension_loaded('gmp')) {
            throw new \RuntimeException('You need to install GMP extension to run this code with x86 PHP build.');
        }
        $this->buffer = $buffer;
        $this->position = 0;
        $this->length = strlen($buffer);
        $this->field = 0;
        $this->stack = [];
        $this->handler = $handler;
        $this->parse();
    }

    /**
     * Parser.
     */
    private function parse()
    {
        $context = '';
        while ($this->position < $this->length) {
            $type = $this->readField();
            switch ($type) {
                case Compact::TYPE_STRUCT:
                    array_push($this->stack, $this->field);
                    $this->field = 0;
                    $context = implode('/', $this->stack);
                    break;
                case Compact::TYPE_STOP:
                    if (!count($this->stack)) {
                        return;
                    }
                    $this->field = array_pop($this->stack);
                    $context = implode('/', $this->stack);
                    break;
                case Compact::TYPE_LIST:
                    $sizeAndType = $this->readUnsignedByte();
                    $size = $sizeAndType >> 4;
                    $listType = $sizeAndType & 0x0f;
                    if ($size === 0x0f) {
                        $size = $this->readVarint();
                    }
                    $this->handleField($context, $this->field, $this->readList($size, $listType), $listType);
                    break;
                case Compact::TYPE_TRUE:
                case Compact::TYPE_FALSE:
                    $this->handleField($context, $this->field, $type === Compact::TYPE_TRUE, $type);
                    break;
                case Compact::TYPE_BYTE:
                    $this->handleField($context, $this->field, $this->readSignedByte(), $type);
                    break;
                case Compact::TYPE_I16:
                case Compact::TYPE_I32:
                case Compact::TYPE_I64:
                    $this->handleField($context, $this->field, $this->fromZigZag($this->readVarint()), $type);
                    break;
                case Compact::TYPE_BINARY:
                    $this->handleField($context, $this->field, $this->readString($this->readVarint()), $type);
                    break;
            }
        }
    }

    /**
     * @param int $size
     * @param int $type
     *
     * @return array
     */
    private function readList($size, $type)
    {
        $result = [];
        switch ($type) {
            case Compact::TYPE_TRUE:
            case Compact::TYPE_FALSE:
                for ($i = 0; $i < $size; $i++) {
                    $result[] = $this->readSignedByte() === Compact::TYPE_TRUE;
                }
                break;
            case Compact::TYPE_BYTE:
                for ($i = 0; $i < $size; $i++) {
                    $result[] = $this->readSignedByte();
                }
                break;
            case Compact::TYPE_I16:
            case Compact::TYPE_I32:
            case Compact::TYPE_I64:
                for ($i = 0; $i < $size; $i++) {
                    $result[] = $this->fromZigZag($this->readVarint());
                }
                break;
            case Compact::TYPE_BINARY:
                $result[] = $this->readString($this->readVarint());
                break;
        }

        return $result;
    }

    /**
     * @return int
     */
    private function readField()
    {
        $typeAndDelta = ord($this->buffer[$this->position++]);
        if ($typeAndDelta === Compact::TYPE_STOP) {
            return Compact::TYPE_STOP;
        }
        $delta = $typeAndDelta >> 4;
        if ($delta === 0) {
            $this->field = $this->fromZigZag($this->readVarint());
        } else {
            $this->field += $delta;
        }
        $type = $typeAndDelta & 0x0f;

        return $type;
    }

    /**
     * @return int
     */
    private function readSignedByte()
    {
        $result = $this->readUnsignedByte();
        if ($result > 0x7f) {
            $result = 0 - (($result - 1) ^ 0xff);
        }

        return $result;
    }

    /**
     * @return int
     */
    private function readUnsignedByte()
    {
        return ord($this->buffer[$this->position++]);
    }

    /**
     * @return int
     */
    private function readVarint()
    {
        $shift = 0;
        $result = 0;
        if (PHP_INT_SIZE === 4) {
            $result = gmp_init($result, 10);
        }
        while ($this->position < $this->length) {
            $byte = ord($this->buffer[$this->position++]);
            if (PHP_INT_SIZE === 4) {
                $byte = gmp_init($byte, 10);
            }
            $result |= ($byte & 0x7f) << $shift;
            if (PHP_INT_SIZE === 4) {
                $byte = (int) gmp_strval($byte, 10);
            }
            if ($byte >> 7 === 0) {
                break;
            }
            $shift += 7;
        }
        if (PHP_INT_SIZE === 4) {
            $result = gmp_strval($result, 10);
        }

        return $result;
    }

    /**
     * @param int $n
     *
     * @return int
     */
    private function fromZigZag($n)
    {
        if (PHP_INT_SIZE === 4) {
            $n = gmp_init($n, 10);
        }
        $result = ($n >> 1) ^ -($n & 1);
        if (PHP_INT_SIZE === 4) {
            $result = gmp_strval($result, 10);
        }

        return $result;
    }

    /**
     * @param int $length
     *
     * @return string
     */
    private function readString($length)
    {
        $result = substr($this->buffer, $this->position, $length);
        $this->position += $length;

        return $result;
    }

    /**
     * @param string $context
     * @param int    $field
     * @param mixed  $value
     * @param int    $type
     */
    private function handleField($context, $field, $value, $type)
    {
        if (!is_callable($this->handler)) {
            return;
        }
        call_user_func($this->handler, $context, $field, $value, $type);
    }
}
