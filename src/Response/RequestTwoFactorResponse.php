<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method mixed getObfuscatedPhoneNumber()
 * @method Model\PhoneVerificationSettings getPhoneVerificationSettings()
 * @method bool isObfuscatedPhoneNumber()
 * @method bool isPhoneVerificationSettings()
 * @method setObfuscatedPhoneNumber(mixed $value)
 * @method setPhoneVerificationSettings(Model\PhoneVerificationSettings $value)
 */
class RequestTwoFactorResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    /**
     * @var Model\PhoneVerificationSettings
     */
    public $phone_verification_settings;
    public $obfuscated_phone_number;
}
