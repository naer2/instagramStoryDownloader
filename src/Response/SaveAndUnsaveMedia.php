<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

class SaveAndUnsaveMedia extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;
}
