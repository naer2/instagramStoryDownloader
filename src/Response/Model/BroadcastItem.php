<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method mixed getBroadcastMessage()
 * @method User getBroadcastOwner()
 * @method mixed getBroadcastStatus()
 * @method mixed getCoverFrameUrl()
 * @method mixed getDashAbrPlaybackUrl()
 * @method mixed getDashPlaybackUrl()
 * @method string getId()
 * @method string getMediaId()
 * @method mixed getOrganicTrackingToken()
 * @method mixed getPublishedTime()
 * @method mixed getRtmpPlaybackUrl()
 * @method mixed getViewerCount()
 * @method bool isBroadcastMessage()
 * @method bool isBroadcastOwner()
 * @method bool isBroadcastStatus()
 * @method bool isCoverFrameUrl()
 * @method bool isDashAbrPlaybackUrl()
 * @method bool isDashPlaybackUrl()
 * @method bool isId()
 * @method bool isMediaId()
 * @method bool isOrganicTrackingToken()
 * @method bool isPublishedTime()
 * @method bool isRtmpPlaybackUrl()
 * @method bool isViewerCount()
 * @method setBroadcastMessage(mixed $value)
 * @method setBroadcastOwner(User $value)
 * @method setBroadcastStatus(mixed $value)
 * @method setCoverFrameUrl(mixed $value)
 * @method setDashAbrPlaybackUrl(mixed $value)
 * @method setDashPlaybackUrl(mixed $value)
 * @method setId(string $value)
 * @method setMediaId(string $value)
 * @method setOrganicTrackingToken(mixed $value)
 * @method setPublishedTime(mixed $value)
 * @method setRtmpPlaybackUrl(mixed $value)
 * @method setViewerCount(mixed $value)
 */
class BroadcastItem extends AutoPropertyHandler
{
    public $organic_tracking_token;
    public $published_time;
    /**
     * @var string
     */
    public $id;
    public $rtmp_playback_url;
    public $cover_frame_url;
    public $broadcast_status;
    /**
     * @var string
     */
    public $media_id;
    public $broadcast_message;
    public $viewer_count;
    public $dash_abr_playback_url;
    public $dash_playback_url;
    /**
     * @var User
     */
    public $broadcast_owner;
}
