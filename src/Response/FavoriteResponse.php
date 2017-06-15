<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

class FavoriteResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;
}
