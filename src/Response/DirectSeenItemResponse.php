<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method mixed getAction()
 * @method Model\DirectSeenItemPayload getPayload()
 * @method bool isAction()
 * @method bool isPayload()
 * @method setAction(mixed $value)
 * @method setPayload(Model\DirectSeenItemPayload $value)
 */
class DirectSeenItemResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    public $action;
    /** @var Model\DirectSeenItemPayload */
    public $payload; // this is the number of unseen items
}
