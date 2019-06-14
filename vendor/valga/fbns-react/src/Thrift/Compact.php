<?php

namespace Fbns\Client\Thrift;

/**
 * @see https://thrift.apache.org/
 */
class Compact
{
    const TYPE_STOP = 0x00;
    const TYPE_TRUE = 0x01;
    const TYPE_FALSE = 0x02;
    const TYPE_BYTE = 0x03;
    const TYPE_I16 = 0x04;
    const TYPE_I32 = 0x05;
    const TYPE_I64 = 0x06;
    const TYPE_DOUBLE = 0x07;
    const TYPE_BINARY = 0x08;
    const TYPE_LIST = 0x09;
    const TYPE_SET = 0x0A;
    const TYPE_MAP = 0x0B;
    const TYPE_STRUCT = 0x0C;
    const TYPE_FLOAT = 0x0D;
}
