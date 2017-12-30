<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyMapper;

/**
 * ProfilePicture.
 *
 * @method mixed getUri()
 * @method bool isUri()
 * @method $this setUri(mixed $value)
 * @method $this unsetUri()
 */
class ProfilePicture extends AutoPropertyMapper
{
    const JSON_PROPERTY_MAP = [
        'uri' => '',
    ];
}
