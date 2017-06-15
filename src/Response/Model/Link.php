<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method mixed getEnd()
 * @method string getId()
 * @method mixed getStart()
 * @method mixed getType()
 * @method bool isEnd()
 * @method bool isId()
 * @method bool isStart()
 * @method bool isType()
 * @method setEnd(mixed $value)
 * @method setId(string $value)
 * @method setStart(mixed $value)
 * @method setType(mixed $value)
 */
class Link extends AutoPropertyHandler
{
    public $start;
    public $end;
    /**
     * @var string
     */
    public $id;
    public $type;
}
