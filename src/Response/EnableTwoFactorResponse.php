<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method mixed getBackupCodes()
 * @method bool isBackupCodes()
 * @method setBackupCodes(mixed $value)
 */
class EnableTwoFactorResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    public $backup_codes;
}
