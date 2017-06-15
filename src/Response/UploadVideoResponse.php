<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method float getConfigureDelayMs()
 * @method mixed getResult()
 * @method string getUploadId()
 * @method bool isConfigureDelayMs()
 * @method bool isResult()
 * @method bool isUploadId()
 * @method setConfigureDelayMs(float $value)
 * @method setResult(mixed $value)
 * @method setUploadId(string $value)
 */
class UploadVideoResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    /**
     * @var string
     */
    public $upload_id;
    /**
     * @var float
     */
    public $configure_delay_ms;
    public $result;
}
