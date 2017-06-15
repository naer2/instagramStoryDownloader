<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method mixed getBundles()
 * @method string getRequestId()
 * @method bool isBundles()
 * @method bool isRequestId()
 * @method setBundles(mixed $value)
 * @method setRequestId(string $value)
 */
class FacebookOTAResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    public $bundles;
    /**
     * @var string
     */
    public $request_id;
}
