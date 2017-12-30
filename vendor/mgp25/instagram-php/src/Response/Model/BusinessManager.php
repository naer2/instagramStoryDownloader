<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyMapper;

/**
 * BusinessManager.
 *
 * @method BusinessNode getAccountInsightsUnit()
 * @method PromotionsUnit getPromotionsUnit()
 * @method BusinessFeed get_Feed2py0Z1()
 * @method bool isAccountInsightsUnit()
 * @method bool isPromotionsUnit()
 * @method bool is_Feed2py0Z1()
 * @method $this setAccountInsightsUnit(BusinessNode $value)
 * @method $this setPromotionsUnit(PromotionsUnit $value)
 * @method $this set_Feed2py0Z1(BusinessFeed $value)
 * @method $this unsetAccountInsightsUnit()
 * @method $this unsetPromotionsUnit()
 * @method $this unset_Feed2py0Z1()
 */
class BusinessManager extends AutoPropertyMapper
{
    const JSON_PROPERTY_MAP = [
        'promotions_unit'       => 'PromotionsUnit',
        'account_insights_unit' => 'BusinessNode',
        '_feed2py0Z1'           => 'BusinessFeed',
    ];
}
