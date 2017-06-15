<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method Model\BlockedReels getBlockedReels()
 * @method mixed getMessagePrefs()
 * @method bool isBlockedReels()
 * @method bool isMessagePrefs()
 * @method setBlockedReels(Model\BlockedReels $value)
 * @method setMessagePrefs(mixed $value)
 */
class ReelSettingsResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    public $message_prefs;
    /**
     * @var Model\BlockedReels
     */
    public $blocked_reels;
}
