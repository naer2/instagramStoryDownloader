<?php

namespace InstagramAPI\Realtime\Event\Payload;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method mixed getActivityStatus()
 * @method string getSenderId()
 * @method mixed getTimestamp()
 * @method mixed getTtl()
 * @method bool isActivityStatus()
 * @method bool isSenderId()
 * @method bool isTimestamp()
 * @method bool isTtl()
 * @method setActivityStatus(mixed $value)
 * @method setSenderId(string $value)
 * @method setTimestamp(mixed $value)
 * @method setTtl(mixed $value)
 */
class Activity extends AutoPropertyHandler
{
    public $timestamp;
    /** @var string */
    public $sender_id;
    public $activity_status;
    public $ttl;
}
