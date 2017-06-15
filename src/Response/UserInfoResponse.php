<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method mixed getMegaphone()
 * @method Model\User getUser()
 * @method bool isMegaphone()
 * @method bool isUser()
 * @method setMegaphone(mixed $value)
 * @method setUser(Model\User $value)
 */
class UserInfoResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    public $megaphone;
    /**
     * @var Model\User
     */
    public $user;
}
