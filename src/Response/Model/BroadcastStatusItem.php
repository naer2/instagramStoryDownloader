<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method mixed getBroadcastStatus()
 * @method mixed getCoverFrameUrl()
 * @method mixed getHasReducedVisibility()
 * @method string getId()
 * @method mixed getViewerCount()
 * @method bool isBroadcastStatus()
 * @method bool isCoverFrameUrl()
 * @method bool isHasReducedVisibility()
 * @method bool isId()
 * @method bool isViewerCount()
 * @method setBroadcastStatus(mixed $value)
 * @method setCoverFrameUrl(mixed $value)
 * @method setHasReducedVisibility(mixed $value)
 * @method setId(string $value)
 * @method setViewerCount(mixed $value)
 */
class BroadcastStatusItem extends AutoPropertyHandler
{
    public $broadcast_status;
    public $has_reduced_visibility;
    public $cover_frame_url;
    public $viewer_count;
    /**
     * @var string
     */
    public $id;
}
