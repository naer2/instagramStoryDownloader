<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method mixed getAutoDvance()
 * @method string getId()
 * @method mixed getLandingSiteTitle()
 * @method mixed getLandingSiteType()
 * @method mixed getSuggestions()
 * @method mixed getTitle()
 * @method mixed getTrackingToken()
 * @method mixed getType()
 * @method mixed getUpsellFbPos()
 * @method mixed getViewAllText()
 * @method bool isAutoDvance()
 * @method bool isId()
 * @method bool isLandingSiteTitle()
 * @method bool isLandingSiteType()
 * @method bool isSuggestions()
 * @method bool isTitle()
 * @method bool isTrackingToken()
 * @method bool isType()
 * @method bool isUpsellFbPos()
 * @method bool isViewAllText()
 * @method setAutoDvance(mixed $value)
 * @method setId(string $value)
 * @method setLandingSiteTitle(mixed $value)
 * @method setLandingSiteType(mixed $value)
 * @method setSuggestions(mixed $value)
 * @method setTitle(mixed $value)
 * @method setTrackingToken(mixed $value)
 * @method setType(mixed $value)
 * @method setUpsellFbPos(mixed $value)
 * @method setViewAllText(mixed $value)
 */
class SuggestedUsers extends AutoPropertyHandler
{
    /**
     * @var string
     */
    public $id;
    public $view_all_text;
    public $title;
    public $auto_dvance;
    public $type;
    public $tracking_token;
    public $landing_site_type;
    public $landing_site_title;
    public $upsell_fb_pos;
    /*
     * @var Suggestion[]
     */
    public $suggestions;
}
