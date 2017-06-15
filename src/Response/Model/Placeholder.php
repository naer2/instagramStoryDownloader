<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method mixed getIsLinked()
 * @method mixed getMessage()
 * @method mixed getTitle()
 * @method bool isIsLinked()
 * @method bool isMessage()
 * @method bool isTitle()
 * @method setIsLinked(mixed $value)
 * @method setMessage(mixed $value)
 * @method setTitle(mixed $value)
 */
class Placeholder extends AutoPropertyHandler
{
    public $is_linked;
    public $title;
    public $message;
}
