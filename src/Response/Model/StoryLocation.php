<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method float getHeight()
 * @method Location getLocation()
 * @method float getRotation()
 * @method float getWidth()
 * @method float getX()
 * @method float getY()
 * @method bool isHeight()
 * @method bool isLocation()
 * @method bool isRotation()
 * @method bool isWidth()
 * @method bool isX()
 * @method bool isY()
 * @method setHeight(float $value)
 * @method setLocation(Location $value)
 * @method setRotation(float $value)
 * @method setWidth(float $value)
 * @method setX(float $value)
 * @method setY(float $value)
 */
class StoryLocation extends AutoPropertyHandler
{
    /**
     * @var float
     */
    public $rotation;
    /**
     * @var float
     */
    public $x;
    /**
     * @var float
     */
    public $y;
    /**
     * @var float
     */
    public $height;
    /**
     * @var float
     */
    public $width;
    /**
     * @var Location
     */
    public $location;
}
