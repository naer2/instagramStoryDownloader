<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method string getRequestId()
 * @method Model\Location[] getVenues()
 * @method bool isRequestId()
 * @method bool isVenues()
 * @method setRequestId(string $value)
 * @method setVenues(Model\Location[] $value)
 */
class LocationResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    /**
     * @var Model\Location[]
     */
    public $venues;
    /**
     * @var string
     */
    public $request_id;
}
