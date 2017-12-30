<?php

namespace InstagramAPI\Response;

use InstagramAPI\Response;

/**
 * FBSearchResponse.
 *
 * @method bool getHasMore()
 * @method mixed getHashtags()
 * @method mixed getMessage()
 * @method mixed getPlaces()
 * @method string getRankToken()
 * @method string getStatus()
 * @method mixed getUsers()
 * @method Model\_Message[] get_Messages()
 * @method bool isHasMore()
 * @method bool isHashtags()
 * @method bool isMessage()
 * @method bool isPlaces()
 * @method bool isRankToken()
 * @method bool isStatus()
 * @method bool isUsers()
 * @method bool is_Messages()
 * @method $this setHasMore(bool $value)
 * @method $this setHashtags(mixed $value)
 * @method $this setMessage(mixed $value)
 * @method $this setPlaces(mixed $value)
 * @method $this setRankToken(string $value)
 * @method $this setStatus(string $value)
 * @method $this setUsers(mixed $value)
 * @method $this set_Messages(Model\_Message[] $value)
 * @method $this unsetHasMore()
 * @method $this unsetHashtags()
 * @method $this unsetMessage()
 * @method $this unsetPlaces()
 * @method $this unsetRankToken()
 * @method $this unsetStatus()
 * @method $this unsetUsers()
 * @method $this unset_Messages()
 */
class FBSearchResponse extends Response
{
    const JSON_PROPERTY_MAP = [
        'has_more'   => 'bool',
        'hashtags'   => '',
        'users'      => '',
        'places'     => '',
        'rank_token' => 'string',
    ];
}
