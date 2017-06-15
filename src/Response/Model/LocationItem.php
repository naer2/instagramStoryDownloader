<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method Location getLocation()
 * @method mixed getMediaBundles()
 * @method mixed getSubtitle()
 * @method mixed getTitle()
 * @method bool isLocation()
 * @method bool isMediaBundles()
 * @method bool isSubtitle()
 * @method bool isTitle()
 * @method setLocation(Location $value)
 * @method setMediaBundles(mixed $value)
 * @method setSubtitle(mixed $value)
 * @method setTitle(mixed $value)
 */
class LocationItem extends AutoPropertyHandler
{
    public $media_bundles;
    public $subtitle;
    /**
     * @var Location
     */
    public $location;
    public $title;
}
