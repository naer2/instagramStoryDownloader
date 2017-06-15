<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method In[] getIn()
 * @method mixed getPhotoOfYou()
 * @method bool isIn()
 * @method bool isPhotoOfYou()
 * @method setIn(In[] $value)
 * @method setPhotoOfYou(mixed $value)
 */
class Usertag extends AutoPropertyHandler
{
    /**
     * @var In[]
     */
    public $in;
    public $photo_of_you;
}
