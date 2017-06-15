<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method mixed getAndroidClass()
 * @method mixed getCallToActionTitle()
 * @method mixed getDeeplinkUri()
 * @method mixed getLinkType()
 * @method mixed getPackage()
 * @method mixed getWebUri()
 * @method bool isAndroidClass()
 * @method bool isCallToActionTitle()
 * @method bool isDeeplinkUri()
 * @method bool isLinkType()
 * @method bool isPackage()
 * @method bool isWebUri()
 * @method setAndroidClass(mixed $value)
 * @method setCallToActionTitle(mixed $value)
 * @method setDeeplinkUri(mixed $value)
 * @method setLinkType(mixed $value)
 * @method setPackage(mixed $value)
 * @method setWebUri(mixed $value)
 */
class AndroidLinks extends AutoPropertyHandler
{
    public $linkType;
    public $webUri;
    public $androidClass;
    public $package;
    public $deeplinkUri;
    public $callToActionTitle;
}
