<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyMapper;

/**
 * GraphQuery.
 *
 * @method mixed getError()
 * @method QueryResponse getResponse()
 * @method bool isError()
 * @method bool isResponse()
 * @method $this setError(mixed $value)
 * @method $this setResponse(QueryResponse $value)
 * @method $this unsetError()
 * @method $this unsetResponse()
 */
class GraphQuery extends AutoPropertyMapper
{
    const JSON_PROPERTY_MAP = [
        'response' => 'QueryResponse',
        'error'    => '',
    ];
}
