<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method Model\Broadcast[] getBroadcasts()
 * @method mixed getStickerVersion()
 * @method mixed getStoryRankingToken()
 * @method Model\Tray[] getTray()
 * @method bool isBroadcasts()
 * @method bool isStickerVersion()
 * @method bool isStoryRankingToken()
 * @method bool isTray()
 * @method setBroadcasts(Model\Broadcast[] $value)
 * @method setStickerVersion(mixed $value)
 * @method setStoryRankingToken(mixed $value)
 * @method setTray(Model\Tray[] $value)
 */
class ReelsTrayFeedResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    /**
     * @var Model\Tray[]
     */
    public $tray;
    /**
     * @var Model\Broadcast[]
     */
    public $broadcasts;
    public $sticker_version;
    public $story_ranking_token;
}
