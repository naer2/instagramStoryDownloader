<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method Model\DirectInbox getInbox()
 * @method mixed getPendingRequestsTotal()
 * @method string getSeqId()
 * @method bool isInbox()
 * @method bool isPendingRequestsTotal()
 * @method bool isSeqId()
 * @method setInbox(Model\DirectInbox $value)
 * @method setPendingRequestsTotal(mixed $value)
 * @method setSeqId(string $value)
 */
class DirectPendingInboxResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    /**
     * @var string
     */
    public $seq_id;
    public $pending_requests_total;
    /**
     * @var Model\DirectInbox
     */
    public $inbox;
}
