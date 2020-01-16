<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyMapper;

/**
 * TwoByTwoItem.
 *
 * @method Channel getChannel()
 * @method bool isChannel()
 * @method $this setChannel(Channel $value)
 * @method $this unsetChannel()
 */
class TwoByTwoItem extends AutoPropertyMapper
{
    const JSON_PROPERTY_MAP = [
        'channel'     => 'Channel',
    ];
}
