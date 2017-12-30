<?php

namespace BinSoul\Net\Mqtt\Exception;

/**
 * Will be thrown if the end of a stream is reached but more bytes were requested.
 */
class EndOfStreamException extends \Exception
{
}
