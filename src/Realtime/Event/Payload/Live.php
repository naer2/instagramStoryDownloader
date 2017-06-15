<?php

namespace InstagramAPI\Realtime\Event\Payload;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method string getBroadcastId()
 * @method mixed getBroadcastMessage()
 * @method mixed getDisplayNotification()
 * @method mixed getIsPeriodic()
 * @method \InstagramAPI\Response\Model\User getUser()
 * @method bool isBroadcastId()
 * @method bool isBroadcastMessage()
 * @method bool isDisplayNotification()
 * @method bool isIsPeriodic()
 * @method bool isUser()
 * @method setBroadcastId(string $value)
 * @method setBroadcastMessage(mixed $value)
 * @method setDisplayNotification(mixed $value)
 * @method setIsPeriodic(mixed $value)
 * @method setUser(\InstagramAPI\Response\Model\User $value)
 */
class Live extends AutoPropertyHandler
{
    /** @var \InstagramAPI\Response\Model\User */
    public $user;
    /** @var string */
    public $broadcast_id;
    public $is_periodic;
    public $broadcast_message;
    public $display_notification;
}
