<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method mixed getKey()
 * @method mixed getTime()
 * @method bool isKey()
 * @method bool isTime()
 * @method setKey(mixed $value)
 * @method setTime(mixed $value)
 */
class _Message extends AutoPropertyHandler
{
    public $key;
    public $time;
}
