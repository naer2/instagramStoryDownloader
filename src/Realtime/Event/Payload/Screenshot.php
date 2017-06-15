<?php

namespace InstagramAPI\Realtime\Event\Payload;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method \InstagramAPI\Response\Model\User getActionUserDict()
 * @method mixed getMediaType()
 * @method bool isActionUserDict()
 * @method bool isMediaType()
 * @method setActionUserDict(\InstagramAPI\Response\Model\User $value)
 * @method setMediaType(mixed $value)
 */
class Screenshot extends AutoPropertyHandler
{
    /** @var \InstagramAPI\Response\Model\User */
    public $action_user_dict;
    public $media_type;
}
