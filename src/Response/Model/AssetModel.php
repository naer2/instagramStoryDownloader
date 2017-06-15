<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method mixed getAssetUrl()
 * @method string getId()
 * @method bool isAssetUrl()
 * @method bool isId()
 * @method setAssetUrl(mixed $value)
 * @method setId(string $value)
 */
class AssetModel extends AutoPropertyHandler
{
    public $asset_url;
    /**
     * @var string
     */
    public $id;
}
