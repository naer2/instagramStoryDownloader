<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method string getClientSidecarId()
 * @method Model\Item getMedia()
 * @method Model\DirectMessageMetadata[] getMessageMetadata()
 * @method string getUploadId()
 * @method bool isClientSidecarId()
 * @method bool isMedia()
 * @method bool isMessageMetadata()
 * @method bool isUploadId()
 * @method setClientSidecarId(string $value)
 * @method setMedia(Model\Item $value)
 * @method setMessageMetadata(Model\DirectMessageMetadata[] $value)
 * @method setUploadId(string $value)
 */
class ConfigureResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    /**
     * @var string
     */
    public $upload_id;
    /**
     * @var Model\Item
     */
    public $media;
    /**
     * @var string
     */
    public $client_sidecar_id;
    /**
     * @var Model\DirectMessageMetadata[]
     */
    public $message_metadata;
}
