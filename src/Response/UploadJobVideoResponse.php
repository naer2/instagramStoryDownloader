<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method string getUploadId()
 * @method mixed getVideoUploadUrls()
 * @method bool isUploadId()
 * @method bool isVideoUploadUrls()
 * @method setUploadId(string $value)
 * @method setVideoUploadUrls(mixed $value)
 */
class UploadJobVideoResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    /**
     * @var string
     */
    public $upload_id;
    public $video_upload_urls;
}
