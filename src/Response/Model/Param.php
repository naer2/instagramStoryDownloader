<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method mixed getName()
 * @method mixed getValue()
 * @method bool isName()
 * @method bool isValue()
 * @method setName(mixed $value)
 * @method setValue(mixed $value)
 */
class Param extends AutoPropertyHandler
{
    public $name;
    public $value;
}
