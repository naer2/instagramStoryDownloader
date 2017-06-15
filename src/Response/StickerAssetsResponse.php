<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method Model\StaticStickers[] getStaticStickers()
 * @method mixed getVersion()
 * @method bool isStaticStickers()
 * @method bool isVersion()
 * @method setStaticStickers(Model\StaticStickers[] $value)
 * @method setVersion(mixed $value)
 */
class StickerAssetsResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    public $version;
    /**
     * @var Model\StaticStickers[]
     */
    public $static_stickers;
}
