<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method mixed getCount()
 * @method string getTimestamp()
 * @method bool isCount()
 * @method bool isTimestamp()
 * @method setCount(mixed $value)
 * @method setTimestamp(string $value)
 */
class DirectSeenItemPayload extends AutoPropertyHandler
{
    public $count;
    /** @var string */
    public $timestamp;
}
