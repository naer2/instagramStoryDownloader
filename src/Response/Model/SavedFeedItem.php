<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method Item getMedia()
 * @method bool isMedia()
 * @method setMedia(Item $value)
 */
class SavedFeedItem extends AutoPropertyHandler
{
    /**
     * @var Item
     */
    public $media;
}
