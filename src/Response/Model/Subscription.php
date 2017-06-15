<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method mixed getAuth()
 * @method mixed getSequence()
 * @method mixed getTopic()
 * @method mixed getUrl()
 * @method bool isAuth()
 * @method bool isSequence()
 * @method bool isTopic()
 * @method bool isUrl()
 * @method setAuth(mixed $value)
 * @method setSequence(mixed $value)
 * @method setTopic(mixed $value)
 * @method setUrl(mixed $value)
 */
class Subscription extends AutoPropertyHandler
{
    public $topic;
    public $url;
    public $sequence;
    public $auth;
}
