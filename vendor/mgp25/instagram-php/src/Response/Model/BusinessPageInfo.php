<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyMapper;

/**
 * BusinessPageInfo.
 *
 * @method bool getHasNextPage()
 * @method bool getHasPreviousPage()
 * @method bool isHasNextPage()
 * @method bool isHasPreviousPage()
 * @method $this setHasNextPage(bool $value)
 * @method $this setHasPreviousPage(bool $value)
 * @method $this unsetHasNextPage()
 * @method $this unsetHasPreviousPage()
 */
class BusinessPageInfo extends AutoPropertyMapper
{
    const JSON_PROPERTY_MAP = [
        'has_next_page'     => 'bool',
        'has_previous_page' => 'bool',
    ];
}
