<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method string getId()
 * @method mixed getImageHeight()
 * @method mixed getImageUrl()
 * @method mixed getImageWidth()
 * @method mixed getImageWidthRatio()
 * @method mixed getName()
 * @method mixed getTrayImageWidthRatio()
 * @method mixed getType()
 * @method bool isId()
 * @method bool isImageHeight()
 * @method bool isImageUrl()
 * @method bool isImageWidth()
 * @method bool isImageWidthRatio()
 * @method bool isName()
 * @method bool isTrayImageWidthRatio()
 * @method bool isType()
 * @method setId(string $value)
 * @method setImageHeight(mixed $value)
 * @method setImageUrl(mixed $value)
 * @method setImageWidth(mixed $value)
 * @method setImageWidthRatio(mixed $value)
 * @method setName(mixed $value)
 * @method setTrayImageWidthRatio(mixed $value)
 * @method setType(mixed $value)
 */
class Stickers extends AutoPropertyHandler
{
    /**
     * @var string
     */
    public $id;
    public $tray_image_width_ratio;
    public $image_height;
    public $image_width_ratio;
    public $type;
    public $image_width;
    public $name;
    public $image_url;
}
