<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method mixed getPosition()
 * @method mixed getTimeInVideo()
 * @method mixed getUser()
 * @method bool isPosition()
 * @method bool isTimeInVideo()
 * @method bool isUser()
 * @method setPosition(mixed $value)
 * @method setTimeInVideo(mixed $value)
 * @method setUser(mixed $value)
 */
class In extends AutoPropertyHandler
{
    /*
     * @var Position
     */
    public $position;
    /*
     * @var User
     */
    public $user;
    public $time_in_video;
}
