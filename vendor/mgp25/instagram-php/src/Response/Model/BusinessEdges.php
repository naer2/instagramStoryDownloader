<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyMapper;

/**
 * BusinessEdges.
 *
 * @method mixed getCursor()
 * @method BusinessNode getNode()
 * @method bool isCursor()
 * @method bool isNode()
 * @method $this setCursor(mixed $value)
 * @method $this setNode(BusinessNode $value)
 * @method $this unsetCursor()
 * @method $this unsetNode()
 */
class BusinessEdges extends AutoPropertyMapper
{
    const JSON_PROPERTY_MAP = [
        'node'   => 'BusinessNode',
        'cursor' => '',
    ];
}
