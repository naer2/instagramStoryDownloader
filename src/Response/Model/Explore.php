<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method string getActorId()
 * @method mixed getExplanation()
 * @method mixed getSourceToken()
 * @method bool isActorId()
 * @method bool isExplanation()
 * @method bool isSourceToken()
 * @method setActorId(string $value)
 * @method setExplanation(mixed $value)
 * @method setSourceToken(mixed $value)
 */
class Explore extends AutoPropertyHandler
{
    public $explanation;
    /**
     * @var string
     */
    public $actor_id;
    public $source_token;
}
