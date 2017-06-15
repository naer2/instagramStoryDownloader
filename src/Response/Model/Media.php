<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method string getId()
 * @method mixed getImage()
 * @method bool isId()
 * @method bool isImage()
 * @method setId(string $value)
 * @method setImage(mixed $value)
 */
class Media extends AutoPropertyHandler
{
    public $image;
    /**
     * @var string
     */
    public $id;
}
