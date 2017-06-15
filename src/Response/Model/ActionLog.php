<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method Bold[] getBold()
 * @method mixed getDescription()
 * @method bool isBold()
 * @method bool isDescription()
 * @method setBold(Bold[] $value)
 * @method setDescription(mixed $value)
 */
class ActionLog extends AutoPropertyHandler
{
    /**
     * @var Bold[]
     */
    public $bold;
    public $description;
}
