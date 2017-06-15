<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method mixed getExpirationInterval()
 * @method mixed getRecentRecipients()
 * @method bool isExpirationInterval()
 * @method bool isRecentRecipients()
 * @method setExpirationInterval(mixed $value)
 * @method setRecentRecipients(mixed $value)
 */
class DirectRecentRecipientsResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    public $expiration_interval;
    public $recent_recipients;
}
