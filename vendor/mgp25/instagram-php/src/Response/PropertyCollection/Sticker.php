<?php

namespace InstagramAPI\Response\PropertyCollection;

use InstagramAPI\AutoPropertyMapper;

/**
 * Sticker.
 *
 * This property collection represents the placement of a story sticker. It is
 * imported by various kinds of story sticker models.
 *
 * @method float getHeight()
 * @method int getIsPinned()
 * @method float getRotation()
 * @method float getWidth()
 * @method float getX()
 * @method float getY()
 * @method bool isHeight()
 * @method bool isIsPinned()
 * @method bool isRotation()
 * @method bool isWidth()
 * @method bool isX()
 * @method bool isY()
 * @method $this setHeight(float $value)
 * @method $this setIsPinned(int $value)
 * @method $this setRotation(float $value)
 * @method $this setWidth(float $value)
 * @method $this setX(float $value)
 * @method $this setY(float $value)
 * @method $this unsetHeight()
 * @method $this unsetIsPinned()
 * @method $this unsetRotation()
 * @method $this unsetWidth()
 * @method $this unsetX()
 * @method $this unsetY()
 */
class Sticker extends AutoPropertyMapper
{
    const JSON_PROPERTY_MAP = [
        'x'         => 'float',
        'y'         => 'float',
        'width'     => 'float',
        'height'    => 'float',
        'rotation'  => 'float',
        'is_pinned' => 'int',
    ];
}
