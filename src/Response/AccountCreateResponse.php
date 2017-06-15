<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method mixed getAccountCreated()
 * @method Model\User getCreatedUser()
 * @method bool isAccountCreated()
 * @method bool isCreatedUser()
 * @method setAccountCreated(mixed $value)
 * @method setCreatedUser(Model\User $value)
 */
class AccountCreateResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    public $account_created;
    /**
     * @var Model\User
     */
    public $created_user;
}
