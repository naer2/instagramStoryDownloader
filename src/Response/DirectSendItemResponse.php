<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method mixed getAction()
 * @method Model\DirectSendItemPayload getPayload()
 * @method mixed getStatusCode()
 * @method bool isAction()
 * @method bool isPayload()
 * @method bool isStatusCode()
 * @method setAction(mixed $value)
 * @method setPayload(Model\DirectSendItemPayload $value)
 * @method setStatusCode(mixed $value)
 */
class DirectSendItemResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    public $action;
    public $status_code;
    /** @var Model\DirectSendItemPayload */
    public $payload;
}
