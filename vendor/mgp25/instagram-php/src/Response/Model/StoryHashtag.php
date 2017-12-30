<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyMapper;
use InstagramAPI\Response\PropertyCollection;

/**
 * StoryHashtag.
 *
 * @method string getAttribution()
 * @method string getCustomTitle()
 * @method Hashtag getHashtag()
 * @method float getHeight()
 * @method int getIsPinned()
 * @method float getRotation()
 * @method float getWidth()
 * @method float getX()
 * @method float getY()
 * @method bool isAttribution()
 * @method bool isCustomTitle()
 * @method bool isHashtag()
 * @method bool isHeight()
 * @method bool isIsPinned()
 * @method bool isRotation()
 * @method bool isWidth()
 * @method bool isX()
 * @method bool isY()
 * @method $this setAttribution(string $value)
 * @method $this setCustomTitle(string $value)
 * @method $this setHashtag(Hashtag $value)
 * @method $this setHeight(float $value)
 * @method $this setIsPinned(int $value)
 * @method $this setRotation(float $value)
 * @method $this setWidth(float $value)
 * @method $this setX(float $value)
 * @method $this setY(float $value)
 * @method $this unsetAttribution()
 * @method $this unsetCustomTitle()
 * @method $this unsetHashtag()
 * @method $this unsetHeight()
 * @method $this unsetIsPinned()
 * @method $this unsetRotation()
 * @method $this unsetWidth()
 * @method $this unsetX()
 * @method $this unsetY()
 */
class StoryHashtag extends AutoPropertyMapper
{
    const JSON_PROPERTY_MAP = [
        PropertyCollection\Sticker::class,
        'hashtag'       => 'Hashtag',
        'attribution'   => 'string',
        'custom_title'  => 'string',
    ];
}
