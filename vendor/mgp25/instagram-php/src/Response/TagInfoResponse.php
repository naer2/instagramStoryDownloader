<?php

namespace InstagramAPI\Response;

use InstagramAPI\Response;

/**
 * TagInfoResponse.
 *
 * @method int getMediaCount()
 * @method mixed getMessage()
 * @method mixed getProfile()
 * @method string getStatus()
 * @method Model\_Message[] get_Messages()
 * @method bool isMediaCount()
 * @method bool isMessage()
 * @method bool isProfile()
 * @method bool isStatus()
 * @method bool is_Messages()
 * @method $this setMediaCount(int $value)
 * @method $this setMessage(mixed $value)
 * @method $this setProfile(mixed $value)
 * @method $this setStatus(string $value)
 * @method $this set_Messages(Model\_Message[] $value)
 * @method $this unsetMediaCount()
 * @method $this unsetMessage()
 * @method $this unsetProfile()
 * @method $this unsetStatus()
 * @method $this unset_Messages()
 */
class TagInfoResponse extends Response
{
    const JSON_PROPERTY_MAP = [
        'profile'     => '',
        'media_count' => 'int',
    ];
}
