<?php

namespace InstagramAPI\Response;

use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

class DirectVisualThreadResponse extends Model\DirectThread implements ResponseInterface
{
    use ResponseTrait;

    // NOTE: This is a special response object which extends
    // Model\DirectThread to inherit all of its properties!
}
