<?php

namespace InstagramAPI\Response;

use InstagramAPI\Response;

/**
 * FetchQPDataResponse.
 *
 * @method mixed getErrorMsg()
 * @method mixed getExtraInfo()
 * @method mixed getMessage()
 * @method mixed getQpData()
 * @method mixed getRequestStatus()
 * @method string getStatus()
 * @method Model\_Message[] get_Messages()
 * @method bool isErrorMsg()
 * @method bool isExtraInfo()
 * @method bool isMessage()
 * @method bool isQpData()
 * @method bool isRequestStatus()
 * @method bool isStatus()
 * @method bool is_Messages()
 * @method $this setErrorMsg(mixed $value)
 * @method $this setExtraInfo(mixed $value)
 * @method $this setMessage(mixed $value)
 * @method $this setQpData(mixed $value)
 * @method $this setRequestStatus(mixed $value)
 * @method $this setStatus(string $value)
 * @method $this set_Messages(Model\_Message[] $value)
 * @method $this unsetErrorMsg()
 * @method $this unsetExtraInfo()
 * @method $this unsetMessage()
 * @method $this unsetQpData()
 * @method $this unsetRequestStatus()
 * @method $this unsetStatus()
 * @method $this unset_Messages()
 */
class FetchQPDataResponse extends Response
{
    const JSON_PROPERTY_MAP = [
        'qp_data'        => '',
        'request_status' => '',
        'extra_info'     => '',
        'error_msg'      => '',
    ];
}
