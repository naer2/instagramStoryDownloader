<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method mixed getButtons()
 * @method mixed getCheckpointUrl()
 * @method mixed getErrorTitle()
 * @method mixed getErrorType()
 * @method mixed getFullName()
 * @method mixed getHasAnonymousProfilePicture()
 * @method mixed getHelpUrl()
 * @method mixed getInvalidCredentials()
 * @method mixed getIsPrivate()
 * @method mixed getLock()
 * @method Model\User getLoggedInUser()
 * @method Model\PhoneVerificationSettings getPhoneVerificationSettings()
 * @method string getPk()
 * @method string getProfilePicId()
 * @method mixed getProfilePicUrl()
 * @method Model\TwoFactorInfo getTwoFactorInfo()
 * @method mixed getTwoFactorRequired()
 * @method mixed getUsername()
 * @method bool isButtons()
 * @method bool isCheckpointUrl()
 * @method bool isErrorTitle()
 * @method bool isErrorType()
 * @method bool isFullName()
 * @method bool isHasAnonymousProfilePicture()
 * @method bool isHelpUrl()
 * @method bool isInvalidCredentials()
 * @method bool isIsPrivate()
 * @method bool isLock()
 * @method bool isLoggedInUser()
 * @method bool isPhoneVerificationSettings()
 * @method bool isPk()
 * @method bool isProfilePicId()
 * @method bool isProfilePicUrl()
 * @method bool isTwoFactorInfo()
 * @method bool isTwoFactorRequired()
 * @method bool isUsername()
 * @method setButtons(mixed $value)
 * @method setCheckpointUrl(mixed $value)
 * @method setErrorTitle(mixed $value)
 * @method setErrorType(mixed $value)
 * @method setFullName(mixed $value)
 * @method setHasAnonymousProfilePicture(mixed $value)
 * @method setHelpUrl(mixed $value)
 * @method setInvalidCredentials(mixed $value)
 * @method setIsPrivate(mixed $value)
 * @method setLock(mixed $value)
 * @method setLoggedInUser(Model\User $value)
 * @method setPhoneVerificationSettings(Model\PhoneVerificationSettings $value)
 * @method setPk(string $value)
 * @method setProfilePicId(string $value)
 * @method setProfilePicUrl(mixed $value)
 * @method setTwoFactorInfo(Model\TwoFactorInfo $value)
 * @method setTwoFactorRequired(mixed $value)
 * @method setUsername(mixed $value)
 */
class LoginResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    public $username;
    public $has_anonymous_profile_picture;
    public $profile_pic_url;
    /**
     * @var string
     */
    public $profile_pic_id;
    public $full_name;
    /**
     * @var string
     */
    public $pk;
    public $is_private;
    public $error_title; // on wrong pass
    public $error_type; // on wrong pass
    public $buttons; // on wrong pass
    public $invalid_credentials; // on wrong pass
    /**
     * @var Model\User
     */
    public $logged_in_user;
    public $two_factor_required;
    /**
     * @var Model\PhoneVerificationSettings
     */
    public $phone_verification_settings;
    /**
     * @var Model\TwoFactorInfo
     */
    public $two_factor_info;
    public $checkpoint_url;
    public $lock;
    public $help_url;
}
