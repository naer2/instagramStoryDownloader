<?php

namespace InstagramAPI\Realtime\Event\Payload;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method \InstagramAPI\Response\Model\ActionLog getActionLog()
 * @method string getUserId()
 * @method bool isActionLog()
 * @method bool isUserId()
 * @method setActionLog(\InstagramAPI\Response\Model\ActionLog $value)
 * @method setUserId(string $value)
 */
class Notify extends AutoPropertyHandler
{
    /** @var string */
    public $user_id;
    /** @var \InstagramAPI\Response\Model\ActionLog */
    public $action_log;
}
