<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyMapper;

/**
 * ReelShare.
 *
 * @method mixed getBroadcasts()
 * @method Item getMedia()
 * @method string getMentionedUserId()
 * @method int getStickerVersion()
 * @method string getStoryRankingToken()
 * @method string getText()
 * @method Item[] getTray()
 * @method mixed getType()
 * @method bool isBroadcasts()
 * @method bool isMedia()
 * @method bool isMentionedUserId()
 * @method bool isStickerVersion()
 * @method bool isStoryRankingToken()
 * @method bool isText()
 * @method bool isTray()
 * @method bool isType()
 * @method $this setBroadcasts(mixed $value)
 * @method $this setMedia(Item $value)
 * @method $this setMentionedUserId(string $value)
 * @method $this setStickerVersion(int $value)
 * @method $this setStoryRankingToken(string $value)
 * @method $this setText(string $value)
 * @method $this setTray(Item[] $value)
 * @method $this setType(mixed $value)
 * @method $this unsetBroadcasts()
 * @method $this unsetMedia()
 * @method $this unsetMentionedUserId()
 * @method $this unsetStickerVersion()
 * @method $this unsetStoryRankingToken()
 * @method $this unsetText()
 * @method $this unsetTray()
 * @method $this unsetType()
 */
class ReelShare extends AutoPropertyMapper
{
    const JSON_PROPERTY_MAP = [
        'tray'                => 'Item[]',
        'story_ranking_token' => 'string',
        'broadcasts'          => '',
        'sticker_version'     => 'int',
        'text'                => 'string',
        'type'                => '',
        'media'               => 'Item',
        'mentioned_user_id'   => 'string',
    ];
}
