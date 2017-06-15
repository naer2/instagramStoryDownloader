<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method mixed getType()
 * @method mixed getValue()
 * @method bool isType()
 * @method bool isValue()
 * @method setType(mixed $value)
 * @method setValue(mixed $value)
 */
class AdMetadata extends AutoPropertyHandler
{
    public $value;
    public $type;
}
