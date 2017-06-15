<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method mixed getGroup()
 * @method mixed getName()
 * @method Param[] getParams()
 * @method bool isGroup()
 * @method bool isName()
 * @method bool isParams()
 * @method setGroup(mixed $value)
 * @method setName(mixed $value)
 * @method setParams(Param[] $value)
 */
class Experiment extends AutoPropertyHandler
{
    /**
     * @var Param[]
     */
    public $params;
    public $group;
    public $name;
}
