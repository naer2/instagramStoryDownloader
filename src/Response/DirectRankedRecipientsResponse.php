<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method mixed getExpires()
 * @method mixed getFiltered()
 * @method mixed getRankToken()
 * @method Model\DirectRankedRecipient[] getRankedRecipients()
 * @method string getRequestId()
 * @method bool isExpires()
 * @method bool isFiltered()
 * @method bool isRankToken()
 * @method bool isRankedRecipients()
 * @method bool isRequestId()
 * @method setExpires(mixed $value)
 * @method setFiltered(mixed $value)
 * @method setRankToken(mixed $value)
 * @method setRankedRecipients(Model\DirectRankedRecipient[] $value)
 * @method setRequestId(string $value)
 */
class DirectRankedRecipientsResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    public $expires;
    /**
     * @var Model\DirectRankedRecipient[]
     */
    public $ranked_recipients;
    public $filtered;
    /**
     * @var string
     */
    public $request_id;
    public $rank_token;
}
