<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method mixed getHasMore()
 * @method mixed getHashtags()
 * @method mixed getPlaces()
 * @method mixed getUsers()
 * @method bool isHasMore()
 * @method bool isHashtags()
 * @method bool isPlaces()
 * @method bool isUsers()
 * @method setHasMore(mixed $value)
 * @method setHashtags(mixed $value)
 * @method setPlaces(mixed $value)
 * @method setUsers(mixed $value)
 */
class FBSearchResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    public $has_more;
    public $hashtags;
    public $users;
    public $places;
}
