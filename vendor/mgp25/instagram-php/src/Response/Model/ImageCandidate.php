<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyMapper;

/**
 * ImageCandidate.
 *
 * @method int getHeight()
 * @method string getUrl()
 * @method int getWidth()
 * @method bool isHeight()
 * @method bool isUrl()
 * @method bool isWidth()
 * @method $this setHeight(int $value)
 * @method $this setUrl(string $value)
 * @method $this setWidth(int $value)
 * @method $this unsetHeight()
 * @method $this unsetUrl()
 * @method $this unsetWidth()
 */
class ImageCandidate extends AutoPropertyMapper
{
    const JSON_PROPERTY_MAP = [
        'url'    => 'string',
        'width'  => 'int',
        'height' => 'int',
    ];
}
