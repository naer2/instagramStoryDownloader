<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method Item[] getItems()
 * @method mixed getMoreAvailable()
 * @method bool isItems()
 * @method bool isMoreAvailable()
 * @method setItems(Item[] $value)
 * @method setMoreAvailable(mixed $value)
 */
class Aymf extends AutoPropertyHandler
{
    /**
     * @var Item[]
     */
    public $items;
    public $more_available;
}
