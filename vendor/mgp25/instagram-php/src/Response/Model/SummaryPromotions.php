<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyMapper;

/**
 * SummaryPromotions.
 *
 * @method BusinessEdges[] getEdges()
 * @method BusinessPageInfo getPageInfo()
 * @method bool isEdges()
 * @method bool isPageInfo()
 * @method $this setEdges(BusinessEdges[] $value)
 * @method $this setPageInfo(BusinessPageInfo $value)
 * @method $this unsetEdges()
 * @method $this unsetPageInfo()
 */
class SummaryPromotions extends AutoPropertyMapper
{
    const JSON_PROPERTY_MAP = [
        'edges'     => 'BusinessEdges[]',
        'page_info' => 'BusinessPageInfo',
    ];
}
