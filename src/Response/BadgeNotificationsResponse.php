<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method mixed getBadgePayload()
 * @method bool isBadgePayload()
 * @method setBadgePayload(mixed $value)
 */
class BadgeNotificationsResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    public $badge_payload; // Only exists if you have notifications, contains data keyed by userId.
}
