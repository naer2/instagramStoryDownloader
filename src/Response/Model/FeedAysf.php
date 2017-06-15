<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method mixed getActivator()
 * @method mixed getDisplayNewUnit()
 * @method mixed getFeedPosition()
 * @method mixed getFetchUserDetails()
 * @method mixed getIsDismissable()
 * @method mixed getLandingSiteTitle()
 * @method mixed getLandingSiteType()
 * @method mixed getShouldRefill()
 * @method mixed getSuggestions()
 * @method mixed getTitle()
 * @method string getUuid()
 * @method mixed getViewAllText()
 * @method bool isActivator()
 * @method bool isDisplayNewUnit()
 * @method bool isFeedPosition()
 * @method bool isFetchUserDetails()
 * @method bool isIsDismissable()
 * @method bool isLandingSiteTitle()
 * @method bool isLandingSiteType()
 * @method bool isShouldRefill()
 * @method bool isSuggestions()
 * @method bool isTitle()
 * @method bool isUuid()
 * @method bool isViewAllText()
 * @method setActivator(mixed $value)
 * @method setDisplayNewUnit(mixed $value)
 * @method setFeedPosition(mixed $value)
 * @method setFetchUserDetails(mixed $value)
 * @method setIsDismissable(mixed $value)
 * @method setLandingSiteTitle(mixed $value)
 * @method setLandingSiteType(mixed $value)
 * @method setShouldRefill(mixed $value)
 * @method setSuggestions(mixed $value)
 * @method setTitle(mixed $value)
 * @method setUuid(string $value)
 * @method setViewAllText(mixed $value)
 */
class FeedAysf extends AutoPropertyHandler
{
    public $landing_site_type;
    /**
     * @var string
     */
    public $uuid;
    public $view_all_text;
    public $feed_position;
    public $landing_site_title;
    public $is_dismissable;
    /*
     * @var Suggestion[]
     */
    public $suggestions;
    public $should_refill;
    public $display_new_unit;
    public $fetch_user_details;
    public $title;
    public $activator;
}
