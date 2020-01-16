<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyMapper;

/**
 * LocationItem.
 *
 * @method Location getLocation()
 * @method mixed getMediaBundles()
 * @method string getSubtitle()
 * @method string getTitle()
 * @method bool isLocation()
 * @method bool isMediaBundles()
 * @method bool isSubtitle()
 * @method bool isTitle()
 * @method $this setLocation(Location $value)
 * @method $this setMediaBundles(mixed $value)
 * @method $this setSubtitle(string $value)
 * @method $this setTitle(string $value)
 * @method $this unsetLocation()
 * @method $this unsetMediaBundles()
 * @method $this unsetSubtitle()
 * @method $this unsetTitle()
 */
class LocationItem extends AutoPropertyMapper
{
    const JSON_PROPERTY_MAP = [
        'media_bundles' => '',
        'subtitle'      => 'string',
        'location'      => 'Location',
        'title'         => 'string',
    ];
}
