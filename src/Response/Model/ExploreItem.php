<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method Channel getChannel()
 * @method Item getMedia()
 * @method Stories getStories()
 * @method bool isChannel()
 * @method bool isMedia()
 * @method bool isStories()
 * @method setChannel(Channel $value)
 * @method setMedia(Item $value)
 * @method setStories(Stories $value)
 */
class ExploreItem extends AutoPropertyHandler
{
    /**
     * @var Item
     */
    public $media;
    /**
     * @var Stories
     */
    public $stories;
    /**
     * @var Channel
     */
    public $channel;
}
