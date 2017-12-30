<?php

namespace InstagramAPI\Response;

use InstagramAPI\Response;

/**
 * ReelsTrayFeedResponse.
 *
 * @method Model\Broadcast[] getBroadcasts()
 * @method int getFaceFilterNuxVersion()
 * @method bool getHasNewNuxStory()
 * @method mixed getMessage()
 * @method Model\PostLive getPostLive()
 * @method string getStatus()
 * @method int getStickerVersion()
 * @method string getStoryRankingToken()
 * @method Model\StoryTray[] getTray()
 * @method Model\_Message[] get_Messages()
 * @method bool isBroadcasts()
 * @method bool isFaceFilterNuxVersion()
 * @method bool isHasNewNuxStory()
 * @method bool isMessage()
 * @method bool isPostLive()
 * @method bool isStatus()
 * @method bool isStickerVersion()
 * @method bool isStoryRankingToken()
 * @method bool isTray()
 * @method bool is_Messages()
 * @method $this setBroadcasts(Model\Broadcast[] $value)
 * @method $this setFaceFilterNuxVersion(int $value)
 * @method $this setHasNewNuxStory(bool $value)
 * @method $this setMessage(mixed $value)
 * @method $this setPostLive(Model\PostLive $value)
 * @method $this setStatus(string $value)
 * @method $this setStickerVersion(int $value)
 * @method $this setStoryRankingToken(string $value)
 * @method $this setTray(Model\StoryTray[] $value)
 * @method $this set_Messages(Model\_Message[] $value)
 * @method $this unsetBroadcasts()
 * @method $this unsetFaceFilterNuxVersion()
 * @method $this unsetHasNewNuxStory()
 * @method $this unsetMessage()
 * @method $this unsetPostLive()
 * @method $this unsetStatus()
 * @method $this unsetStickerVersion()
 * @method $this unsetStoryRankingToken()
 * @method $this unsetTray()
 * @method $this unset_Messages()
 */
class ReelsTrayFeedResponse extends Response
{
    const JSON_PROPERTY_MAP = [
        'tray'                    => 'Model\StoryTray[]',
        'broadcasts'              => 'Model\Broadcast[]',
        'post_live'               => 'Model\PostLive',
        'sticker_version'         => 'int',
        'face_filter_nux_version' => 'int',
        'has_new_nux_story'       => 'bool',
        'story_ranking_token'     => 'string',
    ];
}
