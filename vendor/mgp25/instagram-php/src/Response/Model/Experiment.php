<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyMapper;

/**
 * Experiment.
 *
 * @method mixed getAdditionalParams()
 * @method string getGroup()
 * @method string getName()
 * @method Param[] getParams()
 * @method bool isAdditionalParams()
 * @method bool isGroup()
 * @method bool isName()
 * @method bool isParams()
 * @method $this setAdditionalParams(mixed $value)
 * @method $this setGroup(string $value)
 * @method $this setName(string $value)
 * @method $this setParams(Param[] $value)
 * @method $this unsetAdditionalParams()
 * @method $this unsetGroup()
 * @method $this unsetName()
 * @method $this unsetParams()
 */
class Experiment extends AutoPropertyMapper
{
    const JSON_PROPERTY_MAP = [
        'name'              => 'string',
        'group'             => 'string',
        'additional_params' => '', // TODO: Only seen as [] empty array so far.
        'params'            => 'Param[]',
    ];
}
