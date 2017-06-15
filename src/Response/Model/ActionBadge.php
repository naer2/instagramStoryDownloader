<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method mixed getActionCount()
 * @method mixed getActionTimestamp()
 * @method mixed getActionType()
 * @method bool isActionCount()
 * @method bool isActionTimestamp()
 * @method bool isActionType()
 * @method setActionCount(mixed $value)
 * @method setActionTimestamp(mixed $value)
 * @method setActionType(mixed $value)
 */
class ActionBadge extends AutoPropertyHandler
{
    const DELIVERED = 'raven_delivered';
    const SENT = 'raven_sent';
    const OPENED = 'raven_opened';
    const SCREENSHOT = 'raven_screenshot';
    const REPLAYED = 'raven_replayed';
    const CANNOT_DELIVER = 'raven_cannot_deliver';
    const SENDING = 'raven_sending';
    const BLOCKED = 'raven_blocked';
    const UNKNOWN = 'raven_unknown';
    const SUGGESTED = 'raven_suggested';

    public $action_type;
    public $action_count;
    public $action_timestamp;
}
