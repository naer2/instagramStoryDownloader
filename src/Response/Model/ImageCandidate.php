<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method mixed getHeight()
 * @method mixed getUrl()
 * @method mixed getWidth()
 * @method bool isHeight()
 * @method bool isUrl()
 * @method bool isWidth()
 * @method setHeight(mixed $value)
 * @method setUrl(mixed $value)
 * @method setWidth(mixed $value)
 */
class ImageCandidate extends AutoPropertyHandler
{
    public $url;
    public $width;
    public $height;
}
