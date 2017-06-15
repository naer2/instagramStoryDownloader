<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method string getId()
 * @method mixed getMediaCount()
 * @method mixed getName()
 * @method bool isId()
 * @method bool isMediaCount()
 * @method bool isName()
 * @method setId(string $value)
 * @method setMediaCount(mixed $value)
 * @method setName(mixed $value)
 */
class Tag extends AutoPropertyHandler
{
    public $media_count;
    public $name;
    /**
     * @var string
     */
    public $id;
}
