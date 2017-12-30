<?php

namespace InstagramAPI\Response;

use InstagramAPI\Response;

/**
 * CreateCollectionResponse.
 *
 * @method string getCollectionId()
 * @method mixed getCollectionName()
 * @method mixed getMessage()
 * @method string getStatus()
 * @method Model\_Message[] get_Messages()
 * @method bool isCollectionId()
 * @method bool isCollectionName()
 * @method bool isMessage()
 * @method bool isStatus()
 * @method bool is_Messages()
 * @method $this setCollectionId(string $value)
 * @method $this setCollectionName(mixed $value)
 * @method $this setMessage(mixed $value)
 * @method $this setStatus(string $value)
 * @method $this set_Messages(Model\_Message[] $value)
 * @method $this unsetCollectionId()
 * @method $this unsetCollectionName()
 * @method $this unsetMessage()
 * @method $this unsetStatus()
 * @method $this unset_Messages()
 */
class CreateCollectionResponse extends Response
{
    const JSON_PROPERTY_MAP = [
        'collection_id'   => 'string',
        'collection_name' => '',
    ];
}
