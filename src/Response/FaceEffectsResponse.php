<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method Model\Effect[] getEffects()
 * @method Model\Effect getLoadingEffect()
 * @method mixed getSdkVersion()
 * @method bool isEffects()
 * @method bool isLoadingEffect()
 * @method bool isSdkVersion()
 * @method setEffects(Model\Effect[] $value)
 * @method setLoadingEffect(Model\Effect $value)
 * @method setSdkVersion(mixed $value)
 */
class FaceEffectsResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    public $sdk_version;
    /**
     * @var Model\Effect[]
     */
    public $effects;
    /**
     * @var Model\Effect
     */
    public $loading_effect;
}
