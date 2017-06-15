<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method Model\DirectInbox getInbox()
 * @method mixed getPendingRequestsTotal()
 * @method Model\User[] getPendingRequestsUsers()
 * @method string getSeqId()
 * @method Model\Subscription getSubscription()
 * @method bool isInbox()
 * @method bool isPendingRequestsTotal()
 * @method bool isPendingRequestsUsers()
 * @method bool isSeqId()
 * @method bool isSubscription()
 * @method setInbox(Model\DirectInbox $value)
 * @method setPendingRequestsTotal(mixed $value)
 * @method setPendingRequestsUsers(Model\User[] $value)
 * @method setSeqId(string $value)
 * @method setSubscription(Model\Subscription $value)
 */
class DirectInboxResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    public $pending_requests_total;
    /**
     * @var string
     */
    public $seq_id;
    /**
     * @var Model\User[]
     */
    public $pending_requests_users;
    /**
     * @var Model\DirectInbox
     */
    public $inbox;
    /**
     * @var Model\Subscription
     */
    public $subscription;
}
