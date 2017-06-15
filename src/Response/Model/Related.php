<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method string getId()
 * @method mixed getName()
 * @method mixed getType()
 * @method bool isId()
 * @method bool isName()
 * @method bool isType()
 * @method setId(string $value)
 * @method setName(mixed $value)
 * @method setType(mixed $value)
 */
class Related extends AutoPropertyHandler
{
    public $name;
    /**
     * @var string
     */
    public $id;
    public $type;
}
