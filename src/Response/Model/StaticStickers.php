<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method string getId()
 * @method mixed getIncludeInRecent()
 * @method Stickers[] getStickers()
 * @method bool isId()
 * @method bool isIncludeInRecent()
 * @method bool isStickers()
 * @method setId(string $value)
 * @method setIncludeInRecent(mixed $value)
 * @method setStickers(Stickers[] $value)
 */
class StaticStickers extends AutoPropertyHandler
{
    public $include_in_recent;
    /**
     * @var string
     */
    public $id;
    /**
     * @var Stickers[]
     */
    public $stickers;
}
