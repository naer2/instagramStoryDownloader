<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method mixed getLastCountedAt()
 * @method string getMaxId()
 * @method mixed getNewShares()
 * @method mixed getNewSharesInfo()
 * @method mixed getPatches()
 * @method mixed getShares()
 * @method bool isLastCountedAt()
 * @method bool isMaxId()
 * @method bool isNewShares()
 * @method bool isNewSharesInfo()
 * @method bool isPatches()
 * @method bool isShares()
 * @method setLastCountedAt(mixed $value)
 * @method setMaxId(string $value)
 * @method setNewShares(mixed $value)
 * @method setNewSharesInfo(mixed $value)
 * @method setPatches(mixed $value)
 * @method setShares(mixed $value)
 */
class DirectShareInboxResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    public $shares;
    /**
     * @var string
     */
    public $max_id;
    public $new_shares;
    public $patches;
    public $last_counted_at;
    public $new_shares_info;
}
