<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method mixed getAssetUrl()
 * @method string getEffectFileId()
 * @method string getEffectId()
 * @method string getId()
 * @method mixed getInstructions()
 * @method mixed getThumbnailUrl()
 * @method mixed getTitle()
 * @method bool isAssetUrl()
 * @method bool isEffectFileId()
 * @method bool isEffectId()
 * @method bool isId()
 * @method bool isInstructions()
 * @method bool isThumbnailUrl()
 * @method bool isTitle()
 * @method setAssetUrl(mixed $value)
 * @method setEffectFileId(string $value)
 * @method setEffectId(string $value)
 * @method setId(string $value)
 * @method setInstructions(mixed $value)
 * @method setThumbnailUrl(mixed $value)
 * @method setTitle(mixed $value)
 */
class Effect extends AutoPropertyHandler
{
    public $title;
    /**
     * @var string
     */
    public $id;
    /**
     * @var string
     */
    public $effect_id;
    /**
     * @var string
     */
    public $effect_file_id;
    public $asset_url;
    public $thumbnail_url;
    public $instructions;
}
