<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyMapper;

/**
 * DirectThreadItem.
 *
 * @method ActionLog getActionLog()
 * @method string getClientContext()
 * @method DirectExpiringSummary getExpiringMediaActionSummary()
 * @method mixed getHideInThread()
 * @method string getItemId()
 * @method mixed getItemType()
 * @method mixed getLike()
 * @method DirectLink getLink()
 * @method mixed getLiveVideoShare()
 * @method Location getLocation()
 * @method DirectThreadItemMedia getMedia()
 * @method Item getMediaShare()
 * @method Placeholder getPlaceholder()
 * @method Item[] getPreviewMedias()
 * @method User getProfile()
 * @method Item getRavenMedia()
 * @method DirectReactions getReactions()
 * @method ReelShare getReelShare()
 * @method string[] getSeenUserIds()
 * @method StoryShare getStoryShare()
 * @method string getText()
 * @method mixed getTimestamp()
 * @method string getUserId()
 * @method bool isActionLog()
 * @method bool isClientContext()
 * @method bool isExpiringMediaActionSummary()
 * @method bool isHideInThread()
 * @method bool isItemId()
 * @method bool isItemType()
 * @method bool isLike()
 * @method bool isLink()
 * @method bool isLiveVideoShare()
 * @method bool isLocation()
 * @method bool isMedia()
 * @method bool isMediaShare()
 * @method bool isPlaceholder()
 * @method bool isPreviewMedias()
 * @method bool isProfile()
 * @method bool isRavenMedia()
 * @method bool isReactions()
 * @method bool isReelShare()
 * @method bool isSeenUserIds()
 * @method bool isStoryShare()
 * @method bool isText()
 * @method bool isTimestamp()
 * @method bool isUserId()
 * @method $this setActionLog(ActionLog $value)
 * @method $this setClientContext(string $value)
 * @method $this setExpiringMediaActionSummary(DirectExpiringSummary $value)
 * @method $this setHideInThread(mixed $value)
 * @method $this setItemId(string $value)
 * @method $this setItemType(mixed $value)
 * @method $this setLike(mixed $value)
 * @method $this setLink(DirectLink $value)
 * @method $this setLiveVideoShare(mixed $value)
 * @method $this setLocation(Location $value)
 * @method $this setMedia(DirectThreadItemMedia $value)
 * @method $this setMediaShare(Item $value)
 * @method $this setPlaceholder(Placeholder $value)
 * @method $this setPreviewMedias(Item[] $value)
 * @method $this setProfile(User $value)
 * @method $this setRavenMedia(Item $value)
 * @method $this setReactions(DirectReactions $value)
 * @method $this setReelShare(ReelShare $value)
 * @method $this setSeenUserIds(string[] $value)
 * @method $this setStoryShare(StoryShare $value)
 * @method $this setText(string $value)
 * @method $this setTimestamp(mixed $value)
 * @method $this setUserId(string $value)
 * @method $this unsetActionLog()
 * @method $this unsetClientContext()
 * @method $this unsetExpiringMediaActionSummary()
 * @method $this unsetHideInThread()
 * @method $this unsetItemId()
 * @method $this unsetItemType()
 * @method $this unsetLike()
 * @method $this unsetLink()
 * @method $this unsetLiveVideoShare()
 * @method $this unsetLocation()
 * @method $this unsetMedia()
 * @method $this unsetMediaShare()
 * @method $this unsetPlaceholder()
 * @method $this unsetPreviewMedias()
 * @method $this unsetProfile()
 * @method $this unsetRavenMedia()
 * @method $this unsetReactions()
 * @method $this unsetReelShare()
 * @method $this unsetSeenUserIds()
 * @method $this unsetStoryShare()
 * @method $this unsetText()
 * @method $this unsetTimestamp()
 * @method $this unsetUserId()
 */
class DirectThreadItem extends AutoPropertyMapper
{
    const PLACEHOLDER = 'placeholder';
    const TEXT = 'text';
    const HASHTAG = 'hashtag';
    const LOCATION = 'location';
    const PROFILE = 'profile';
    const MEDIA = 'media';
    const MEDIA_SHARE = 'media_share';
    const EXPIRING_MEDIA = 'raven_media';
    const LIKE = 'like';
    const ACTION_LOG = 'action_log';
    const REACTION = 'reaction';
    const REEL_SHARE = 'reel_share';
    const LINK = 'link';

    const JSON_PROPERTY_MAP = [
        'item_id'                       => 'string',
        'item_type'                     => '',
        'text'                          => 'string',
        'media_share'                   => 'Item',
        'preview_medias'                => 'Item[]',
        'media'                         => 'DirectThreadItemMedia',
        'user_id'                       => 'string',
        'timestamp'                     => '',
        'client_context'                => 'string',
        'hide_in_thread'                => '',
        'action_log'                    => 'ActionLog',
        'link'                          => 'DirectLink',
        'reactions'                     => 'DirectReactions',
        'raven_media'                   => 'Item',
        'seen_user_ids'                 => 'string[]',
        'expiring_media_action_summary' => 'DirectExpiringSummary',
        'reel_share'                    => 'ReelShare',
        'placeholder'                   => 'Placeholder',
        'location'                      => 'Location',
        'like'                          => '',
        'live_video_share'              => '',
        'profile'                       => 'User',
        'story_share'                   => 'StoryShare',
    ];
}
