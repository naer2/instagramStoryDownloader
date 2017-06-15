<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method mixed getBody()
 * @method mixed getIsEmailLegit()
 * @method mixed getTitle()
 * @method bool isBody()
 * @method bool isIsEmailLegit()
 * @method bool isTitle()
 * @method setBody(mixed $value)
 * @method setIsEmailLegit(mixed $value)
 * @method setTitle(mixed $value)
 */
class SendConfirmEmailResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    public $title;
    public $is_email_legit;
    public $body;
}
