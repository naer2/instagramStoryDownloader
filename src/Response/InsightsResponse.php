<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method Model\Insights[] getInstagramUser()
 * @method bool isInstagramUser()
 * @method setInstagramUser(Model\Insights[] $value)
 */
class InsightsResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    /**
     * @var Model\Insights[]
     */
    public $instagram_user;
}
