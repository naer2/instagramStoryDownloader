<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method Args getArgs()
 * @method Counts getCounts()
 * @method string getPk()
 * @method mixed getType()
 * @method bool isArgs()
 * @method bool isCounts()
 * @method bool isPk()
 * @method bool isType()
 * @method setArgs(Args $value)
 * @method setCounts(Counts $value)
 * @method setPk(string $value)
 * @method setType(mixed $value)
 */
class Story extends AutoPropertyHandler
{
    /**
     * @var string
     */
    public $pk;
    /**
     * @var Counts
     */
    public $counts;
    /**
     * @var Args
     */
    public $args;
    public $type;
}
