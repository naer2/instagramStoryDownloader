<?php

namespace Fbns\Client\Thrift;

/**
 * WARNING: This implementation is not complete.
 *
 * @see https://thrift.apache.org/
 */
class Writer
{
    /**
     * @var string
     */
    private $buffer;

    /**
     * @var int
     */
    private $field;

    /**
     * @var int[]
     */
    private $stack;

    /**
     * @param int $number
     * @param int $bits
     *
     * @return int
     */
    private function toZigZag($number, $bits)
    {
        if (PHP_INT_SIZE === 4) {
            $number = gmp_init($number, 10);
        }
        $result = ($number << 1) ^ ($number >> ($bits - 1));
        if (PHP_INT_SIZE === 4) {
            $result = gmp_strval($result, 10);
        }

        return $result;
    }

    /**
     * @param int $number
     */
    private function writeByte($number)
    {
        $this->buffer .= chr($number);
    }

    /**
     * @param int $number
     */
    private function writeWord($number)
    {
        $this->writeVarint($this->toZigZag($number, 16));
    }

    /**
     * @param int $number
     */
    private function writeInt($number)
    {
        $this->writeVarint($this->toZigZag($number, 32));
    }

    /**
     * @param int $number
     */
    private function writeLongInt($number)
    {
        $this->writeVarint($this->toZigZag($number, 64));
    }

    /**
     * @param int $field
     * @param int $type
     */
    private function writeField($field, $type)
    {
        $delta = $field - $this->field;
        if ((0 < $delta) && ($delta <= 15)) {
            $this->writeByte(($delta << 4) | $type);
        } else {
            $this->writeByte($type);
            $this->writeWord($field);
        }
        $this->field = $field;
    }

    /**
     * @param int $number
     */
    private function writeVarint($number)
    {
        if (PHP_INT_SIZE === 4) {
            $number = gmp_init($number, 10);
        }
        while (true) {
            $byte = $number & (~0x7f);
            if (PHP_INT_SIZE === 4) {
                $byte = (int) gmp_strval($byte, 10);
            }
            if ($byte === 0) {
                if (PHP_INT_SIZE === 4) {
                    $number = (int) gmp_strval($number, 10);
                }
                $this->buffer .= chr($number);
                break;
            } else {
                $byte = ($number & 0xff) | 0x80;
                if (PHP_INT_SIZE === 4) {
                    $byte = (int) gmp_strval($byte, 10);
                }
                $this->buffer .= chr($byte);
                $number = $number >> 7;
            }
        }
    }

    /**
     * @param string $data
     */
    private function writeBinary($data)
    {
        $this->buffer .= $data;
    }

    /**
     * @param int  $field
     * @param bool $value
     */
    public function writeBool($field, $value)
    {
        $this->writeField($field, $value ? Compact::TYPE_TRUE : Compact::TYPE_FALSE);
    }

    /**
     * @param int    $field
     * @param string $string
     */
    public function writeString($field, $string)
    {
        $this->writeField($field, Compact::TYPE_BINARY);
        $this->writeVarint(strlen($string));
        $this->writeBinary($string);
    }

    public function writeStop()
    {
        $this->buffer .= chr(Compact::TYPE_STOP);
        if (count($this->stack)) {
            $this->field = array_pop($this->stack);
        }
    }

    /**
     * @param int $field
     * @param int $number
     */
    public function writeInt8($field, $number)
    {
        $this->writeField($field, Compact::TYPE_BYTE);
        $this->writeByte($number);
    }

    /**
     * @param int $field
     * @param int $number
     */
    public function writeInt16($field, $number)
    {
        $this->writeField($field, Compact::TYPE_I16);
        $this->writeWord($number);
    }

    /**
     * @param int $field
     * @param int $number
     */
    public function writeInt32($field, $number)
    {
        $this->writeField($field, Compact::TYPE_I32);
        $this->writeInt($number);
    }

    /**
     * @param int $field
     * @param int $number
     */
    public function writeInt64($field, $number)
    {
        $this->writeField($field, Compact::TYPE_I64);
        $this->writeLongInt($number);
    }

    /**
     * @param int   $field
     * @param int   $type
     * @param array $list
     */
    public function writeList($field, $type, array $list)
    {
        $this->writeField($field, Compact::TYPE_LIST);
        $size = count($list);
        if ($size < 0x0f) {
            $this->writeByte(($size << 4) | $type);
        } else {
            $this->writeByte(0xf0 | $type);
            $this->writeVarint($size);
        }

        switch ($type) {
            case Compact::TYPE_TRUE:
            case Compact::TYPE_FALSE:
                foreach ($list as $value) {
                    $this->writeByte($value ? Compact::TYPE_TRUE : Compact::TYPE_FALSE);
                }
                break;
            case Compact::TYPE_BYTE:
                foreach ($list as $number) {
                    $this->writeByte($number);
                }
                break;
            case Compact::TYPE_I16:
                foreach ($list as $number) {
                    $this->writeWord($number);
                }
                break;
            case Compact::TYPE_I32:
                foreach ($list as $number) {
                    $this->writeInt($number);
                }
                break;
            case Compact::TYPE_I64:
                foreach ($list as $number) {
                    $this->writeLongInt($number);
                }
                break;
            case Compact::TYPE_BINARY:
                foreach ($list as $string) {
                    $this->writeVarint(strlen($string));
                    $this->writeBinary($string);
                }
                break;
        }
    }

    /**
     * @param int $field
     */
    public function writeStruct($field)
    {
        $this->writeField($field, Compact::TYPE_STRUCT);
        $this->stack[] = $this->field;
        $this->field = 0;
    }

    public function __construct()
    {
        if (PHP_INT_SIZE === 4 && !extension_loaded('gmp')) {
            throw new \RuntimeException('You need to install GMP extension to run this code with x86 PHP build.');
        }
        $this->buffer = '';
        $this->field = 0;
        $this->stack = [];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->buffer;
    }
}
