<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method Item[] getItems()
 * @method mixed getType()
 * @method bool isItems()
 * @method bool isType()
 * @method setItems(Item[] $value)
 * @method setType(mixed $value)
 */
class Groups extends AutoPropertyHandler
{
    public $type;
    /**
     * @var Item[]
     */
    public $items;
}
