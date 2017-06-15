<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method mixed getAboutAdParams()
 * @method string getAdId()
 * @method mixed getAdTitle()
 * @method mixed getCookies()
 * @method mixed getDirectShare()
 * @method mixed getDisplayViewabilityEligible()
 * @method mixed getHideFlowType()
 * @method mixed getHideLabel()
 * @method mixed getHideReasonsV2()
 * @method mixed getInvalidation()
 * @method mixed getIsDemo()
 * @method mixed getIsHoldout()
 * @method mixed getLabel()
 * @method mixed getShowAdChoices()
 * @method mixed getShowIcon()
 * @method mixed getTrackingToken()
 * @method mixed getViewTags()
 * @method bool isAboutAdParams()
 * @method bool isAdId()
 * @method bool isAdTitle()
 * @method bool isCookies()
 * @method bool isDirectShare()
 * @method bool isDisplayViewabilityEligible()
 * @method bool isHideFlowType()
 * @method bool isHideLabel()
 * @method bool isHideReasonsV2()
 * @method bool isInvalidation()
 * @method bool isIsDemo()
 * @method bool isIsHoldout()
 * @method bool isLabel()
 * @method bool isShowAdChoices()
 * @method bool isShowIcon()
 * @method bool isTrackingToken()
 * @method bool isViewTags()
 * @method setAboutAdParams(mixed $value)
 * @method setAdId(string $value)
 * @method setAdTitle(mixed $value)
 * @method setCookies(mixed $value)
 * @method setDirectShare(mixed $value)
 * @method setDisplayViewabilityEligible(mixed $value)
 * @method setHideFlowType(mixed $value)
 * @method setHideLabel(mixed $value)
 * @method setHideReasonsV2(mixed $value)
 * @method setInvalidation(mixed $value)
 * @method setIsDemo(mixed $value)
 * @method setIsHoldout(mixed $value)
 * @method setLabel(mixed $value)
 * @method setShowAdChoices(mixed $value)
 * @method setShowIcon(mixed $value)
 * @method setTrackingToken(mixed $value)
 * @method setViewTags(mixed $value)
 */
class Injected extends AutoPropertyHandler
{
    public $label;
    public $show_icon;
    public $hide_label;
    public $invalidation;
    public $is_demo;
    public $view_tags;
    public $is_holdout;
    public $tracking_token;
    public $show_ad_choices;
    public $ad_title;
    public $about_ad_params;
    public $direct_share;
    /**
     * @var string
     */
    public $ad_id;
    public $display_viewability_eligible;
    public $hide_reasons_v2;
    public $hide_flow_type;
    public $cookies;
}
