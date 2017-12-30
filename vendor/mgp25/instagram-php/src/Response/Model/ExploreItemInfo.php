<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyMapper;

/**
 * ExploreItemInfo.
 *
 * @method mixed getAspectRatio()
 * @method mixed getAutoplay()
 * @method mixed getNumColumns()
 * @method mixed getTotalNumColumns()
 * @method bool isAspectRatio()
 * @method bool isAutoplay()
 * @method bool isNumColumns()
 * @method bool isTotalNumColumns()
 * @method $this setAspectRatio(mixed $value)
 * @method $this setAutoplay(mixed $value)
 * @method $this setNumColumns(mixed $value)
 * @method $this setTotalNumColumns(mixed $value)
 * @method $this unsetAspectRatio()
 * @method $this unsetAutoplay()
 * @method $this unsetNumColumns()
 * @method $this unsetTotalNumColumns()
 */
class ExploreItemInfo extends AutoPropertyMapper
{
    const JSON_PROPERTY_MAP = [
        'num_columns'       => '',
        'total_num_columns' => '',
        'aspect_ratio'      => '',
        'autoplay'          => '',
    ];
}
