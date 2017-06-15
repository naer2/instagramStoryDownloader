<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method string[] getNewSuggestionIds()
 * @method mixed getShouldBadge()
 * @method bool isNewSuggestionIds()
 * @method bool isShouldBadge()
 * @method setNewSuggestionIds(string[] $value)
 * @method setShouldBadge(mixed $value)
 */
class SuggestedUsersBadgeResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    public $should_badge;
    /**
     * @var string[]
     */
    public $new_suggestion_ids;
}
