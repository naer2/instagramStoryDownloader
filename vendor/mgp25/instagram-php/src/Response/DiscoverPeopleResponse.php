<?php

namespace InstagramAPI\Response;

use InstagramAPI\Response;

/**
 * DiscoverPeopleResponse.
 *
 * @method Model\Groups[] getGroups()
 * @method string getMaxId()
 * @method mixed getMessage()
 * @method mixed getMoreAvailable()
 * @method string getStatus()
 * @method Model\_Message[] get_Messages()
 * @method bool isGroups()
 * @method bool isMaxId()
 * @method bool isMessage()
 * @method bool isMoreAvailable()
 * @method bool isStatus()
 * @method bool is_Messages()
 * @method $this setGroups(Model\Groups[] $value)
 * @method $this setMaxId(string $value)
 * @method $this setMessage(mixed $value)
 * @method $this setMoreAvailable(mixed $value)
 * @method $this setStatus(string $value)
 * @method $this set_Messages(Model\_Message[] $value)
 * @method $this unsetGroups()
 * @method $this unsetMaxId()
 * @method $this unsetMessage()
 * @method $this unsetMoreAvailable()
 * @method $this unsetStatus()
 * @method $this unset_Messages()
 */
class DiscoverPeopleResponse extends Response
{
    const JSON_PROPERTY_MAP = [
        'groups'         => 'Model\Groups[]',
        'more_available' => '',
        'max_id'         => 'string',
    ];
}
