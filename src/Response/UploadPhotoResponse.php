<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method string getMediaId()
 * @method string getUploadId()
 * @method bool isMediaId()
 * @method bool isUploadId()
 * @method setMediaId(string $value)
 * @method setUploadId(string $value)
 */
class UploadPhotoResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    /**
     * @var string
     */
    public $upload_id;
    /**
     * @var string
     */
    public $media_id;
}
