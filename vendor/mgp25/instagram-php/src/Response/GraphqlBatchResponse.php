<?php

namespace InstagramAPI\Response;

use InstagramAPI\Response;

/**
 * GraphqlBatchResponse.
 *
 * @method mixed getIsError()
 * @method mixed getIsSkipped()
 * @method mixed getIsSuccessful()
 * @method mixed getMessage()
 * @method Model\GraphQuery getQ0()
 * @method string getStatus()
 * @method Model\_Message[] get_Messages()
 * @method bool isIsError()
 * @method bool isIsSkipped()
 * @method bool isIsSuccessful()
 * @method bool isMessage()
 * @method bool isQ0()
 * @method bool isStatus()
 * @method bool is_Messages()
 * @method $this setIsError(mixed $value)
 * @method $this setIsSkipped(mixed $value)
 * @method $this setIsSuccessful(mixed $value)
 * @method $this setMessage(mixed $value)
 * @method $this setQ0(Model\GraphQuery $value)
 * @method $this setStatus(string $value)
 * @method $this set_Messages(Model\_Message[] $value)
 * @method $this unsetIsError()
 * @method $this unsetIsSkipped()
 * @method $this unsetIsSuccessful()
 * @method $this unsetMessage()
 * @method $this unsetQ0()
 * @method $this unsetStatus()
 * @method $this unset_Messages()
 */
class GraphqlBatchResponse extends Response
{
    const JSON_PROPERTY_MAP = [
        'q0'            => 'Model\GraphQuery',
        'is_successful' => '',
        'is_error'      => '',
        'is_skipped'    => '',
    ];

    /**
     * Checks if the response was successful.
     *
     * @return bool
     */
    public function isOk()
    {
        if ($this->_getProperty('q0') !== null && $this->_getProperty('is_successful') == 1) {
            return true;
        } else {
            // Set a nice message for exceptions.
            if ($this->getMessage() === null) {
                $this->setMessage('There was an error while fetching account statistics. Try again later.');
            }

            return false;
        }
    }
}
