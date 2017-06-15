<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method mixed getObfuscatedPhoneNumber()
 * @method PhoneVerificationSettings getPhoneVerificationSettings()
 * @method mixed getTwoFactorIdentifier()
 * @method mixed getUsername()
 * @method bool isObfuscatedPhoneNumber()
 * @method bool isPhoneVerificationSettings()
 * @method bool isTwoFactorIdentifier()
 * @method bool isUsername()
 * @method setObfuscatedPhoneNumber(mixed $value)
 * @method setPhoneVerificationSettings(PhoneVerificationSettings $value)
 * @method setTwoFactorIdentifier(mixed $value)
 * @method setUsername(mixed $value)
 */
class TwoFactorInfo extends AutoPropertyHandler
{
    public $username;
    public $two_factor_identifier;
    /**
     * @var PhoneVerificationSettings
     */
    public $phone_verification_settings;
    public $obfuscated_phone_number;
}
