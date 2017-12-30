<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyMapper;
use InstagramAPI\Response\PropertyCollection;

/**
 * StoryLocation.
 *
 * @method string getAttribution()
 * @method float getHeight()
 * @method int getIsPinned()
 * @method Location getLocation()
 * @method float getRotation()
 * @method float getWidth()
 * @method float getX()
 * @method float getY()
 * @method bool isAttribution()
 * @method bool isHeight()
 * @method bool isIsPinned()
 * @method bool isLocation()
 * @method bool isRotation()
 * @method bool isWidth()
 * @method bool isX()
 * @method bool isY()
 * @method $this setAttribution(string $value)
 * @method $this setHeight(float $value)
 * @method $this setIsPinned(int $value)
 * @method $this setLocation(Location $value)
 * @method $this setRotation(float $value)
 * @method $this setWidth(float $value)
 * @method $this setX(float $value)
 * @method $this setY(float $value)
 * @method $this unsetAttribution()
 * @method $this unsetHeight()
 * @method $this unsetIsPinned()
 * @method $this unsetLocation()
 * @method $this unsetRotation()
 * @method $this unsetWidth()
 * @method $this unsetX()
 * @method $this unsetY()
 */
class StoryLocation extends AutoPropertyMapper
{
    const JSON_PROPERTY_MAP = [
        PropertyCollection\Sticker::class,
        'location'    => 'Location',
        'attribution' => 'string',
    ];
}
