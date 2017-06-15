<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method Model\DirectThread getThread()
 * @method bool isThread()
 * @method setThread(Model\DirectThread $value)
 */
class DirectThreadResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    /**
     * @var Model\DirectThread
     */
    public $thread;
}
