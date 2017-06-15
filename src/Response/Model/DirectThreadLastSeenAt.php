<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method string getItemId()
 * @method mixed getTimestamp()
 * @method bool isItemId()
 * @method bool isTimestamp()
 * @method setItemId(string $value)
 * @method setTimestamp(mixed $value)
 */
class DirectThreadLastSeenAt extends AutoPropertyHandler
{
    /**
     * @var string
     */
    public $item_id;
    public $timestamp;
}
