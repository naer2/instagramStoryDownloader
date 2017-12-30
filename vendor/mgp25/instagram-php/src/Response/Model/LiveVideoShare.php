<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyMapper;

/**
 * LiveVideoShare.
 *
 * @method string getText()
 * @method int getVideoOffset()
 * @method bool isText()
 * @method bool isVideoOffset()
 * @method $this setText(string $value)
 * @method $this setVideoOffset(int $value)
 * @method $this unsetText()
 * @method $this unsetVideoOffset()
 */
class LiveVideoShare extends AutoPropertyMapper
{
    const JSON_PROPERTY_MAP = [
        'text'                => 'string',
        'video_offset'        => 'int',
    ];
}
