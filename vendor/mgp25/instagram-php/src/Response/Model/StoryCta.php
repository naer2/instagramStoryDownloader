<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyMapper;

/**
 * StoryCta.
 *
 * @method AndroidLinks[] getLinks()
 * @method bool isLinks()
 * @method $this setLinks(AndroidLinks[] $value)
 * @method $this unsetLinks()
 */
class StoryCta extends AutoPropertyMapper
{
    const JSON_PROPERTY_MAP = [
        'links'          => 'AndroidLinks[]',
    ];
}
