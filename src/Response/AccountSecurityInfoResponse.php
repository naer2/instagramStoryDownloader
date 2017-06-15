<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method mixed getBackupCodes()
 * @method mixed getCountryCode()
 * @method mixed getIsPhoneConfirmed()
 * @method mixed getIsTwoFactorEnabled()
 * @method mixed getNationalNumber()
 * @method mixed getPhoneNumber()
 * @method bool isBackupCodes()
 * @method bool isCountryCode()
 * @method bool isIsPhoneConfirmed()
 * @method bool isIsTwoFactorEnabled()
 * @method bool isNationalNumber()
 * @method bool isPhoneNumber()
 * @method setBackupCodes(mixed $value)
 * @method setCountryCode(mixed $value)
 * @method setIsPhoneConfirmed(mixed $value)
 * @method setIsTwoFactorEnabled(mixed $value)
 * @method setNationalNumber(mixed $value)
 * @method setPhoneNumber(mixed $value)
 */
class AccountSecurityInfoResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    public $backup_codes;
    public $is_phone_confirmed;
    public $country_code;
    public $phone_number;
    public $is_two_factor_enabled;
    public $national_number;
}
