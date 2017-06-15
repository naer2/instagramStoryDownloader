<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method DirectThread getThread()
 * @method User getUser()
 * @method bool isThread()
 * @method bool isUser()
 * @method setThread(DirectThread $value)
 * @method setUser(User $value)
 */
class DirectRankedRecipient extends AutoPropertyHandler
{
    /**
     * @var DirectThread
     */
    public $thread;
    /**
     * @var User
     */
    public $user;
}
