<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyMapper;

/**
 * Tag.
 *
 * @method string getId()
 * @method int getMediaCount()
 * @method string getName()
 * @method bool isId()
 * @method bool isMediaCount()
 * @method bool isName()
 * @method $this setId(string $value)
 * @method $this setMediaCount(int $value)
 * @method $this setName(string $value)
 * @method $this unsetId()
 * @method $this unsetMediaCount()
 * @method $this unsetName()
 */
class Tag extends AutoPropertyMapper
{
    const JSON_PROPERTY_MAP = [
        'media_count' => 'int',
        'name'        => 'string',
        'id'          => 'string',
    ];
}
