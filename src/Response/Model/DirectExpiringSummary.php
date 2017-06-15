<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method int getCount()
 * @method string getTimestamp()
 * @method string getType()
 * @method bool isCount()
 * @method bool isTimestamp()
 * @method bool isType()
 * @method setCount(int $value)
 * @method setTimestamp(string $value)
 * @method setType(string $value)
 */
class DirectExpiringSummary extends AutoPropertyHandler
{
    /** @var string */
    public $type;
    /** @var string */
    public $timestamp;
    /** @var int */
    public $count;
}
