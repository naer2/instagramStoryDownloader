<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method Model\Reel[] getReels()
 * @method Model\Reel[] getReelsMedia()
 * @method bool isReels()
 * @method bool isReelsMedia()
 * @method setReels(Model\Reel[] $value)
 * @method setReelsMedia(Model\Reel[] $value)
 */
class ReelsMediaResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    /**
     * @var Model\Reel[]
     */
    public $reels_media;
    /**
     * @var Model\Reel[]
     */
    public $reels;
}
