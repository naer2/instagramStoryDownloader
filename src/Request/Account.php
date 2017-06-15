<?php

namespace InstagramAPI\Request;

use InstagramAPI\Response;

/**
 * Account-related functions, such as profile editing and security.
 */
class Account extends RequestCollection
{
    /**
     * Get details about the currently logged in account.
     *
     * Also try People::getSelfInfo() instead, for some different information.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\UserInfoResponse
     *
     * @see People::getSelfInfo()
     */
    public function getCurrentUser()
    {
        return $this->ig->request('accounts/current_user/')
            ->addParam('edit', true)
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->getResponse(new Response\UserInfoResponse());
    }

    /**
     * Edit your profile.
     *
     * @param string $url       Website URL. Use "" for nothing.
     * @param string $phone     Phone number. Use "" for nothing.
     * @param string $name      Name. Use "" for nothing.
     * @param string $biography Biography text. Use "" for nothing.
     * @param string $email     Email. Required.
     * @param int    $gender    Gender. Male = 1, Female = 2, Unknown = 3.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\UserInfoResponse
     */
    public function editProfile(
        $url,
        $phone,
        $name,
        $biography,
        $email,
        $gender)
    {
        return $this->ig->request('accounts/edit_profile/')
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->addPost('external_url', $url)
            ->addPost('phone_number', $phone)
            ->addPost('username', $this->ig->username)
            ->addPost('first_name', $name)
            ->addPost('biography', $biography)
            ->addPost('email', $email)
            ->addPost('gender', $gender)
            ->getResponse(new Response\UserInfoResponse());
    }

    /**
     * Set your account's name and phone.
     *
     * @param string $name  Your name.
     * @param string $phone Your phone number (optional).
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\GenericResponse
     */
    public function setNameAndPhone(
        $name = '',
        $phone = '')
    {
        return $this->ig->request('accounts/set_phone_and_name/')
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->addPost('first_name', $name)
            ->addPost('phone_number', $phone)
            ->getResponse(new Response\GenericResponse());
    }

    /**
     * Changes your account's profile picture.
     *
     * @param string $photoFilename The photo filename.
     *
     * @throws \InvalidArgumentException
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\UserInfoResponse
     */
    public function changeProfilePicture(
        $photoFilename)
    {
        return $this->ig->request('accounts/change_profile_picture/')
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addFile('profile_pic', $photoFilename, 'profile_pic')
            ->getResponse(new Response\UserInfoResponse());
    }

    /**
     * Remove your account's profile picture.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\UserInfoResponse
     */
    public function removeProfilePicture()
    {
        return $this->ig->request('accounts/remove_profile_picture/')
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->getResponse(new Response\UserInfoResponse());
    }

    /**
     * Sets your account to public.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\UserInfoResponse
     */
    public function setPublic()
    {
        return $this->ig->request('accounts/set_public/')
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->getResponse(new Response\UserInfoResponse());
    }

    /**
     * Sets your account to private.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\UserInfoResponse
     */
    public function setPrivate()
    {
        return $this->ig->request('accounts/set_private/')
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->getResponse(new Response\UserInfoResponse());
    }

    /**
     * Get account spam filter status.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\CommentFilterResponse
     */
    public function getCommentFilter()
    {
        return $this->ig->request('accounts/get_comment_filter/')
            ->getResponse(new Response\CommentFilterResponse());
    }

    /**
     * Set account spam filter status (on/off).
     *
     * @param int $config_value Whether spam filter is on (0 or 1).
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\CommentFilterSetResponse
     */
    public function setCommentFilter(
        $config_value)
    {
        return $this->ig->request('accounts/set_comment_filter/')
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->addPost('config_value', $config_value)
            ->getResponse(new Response\CommentFilterSetResponse());
    }

    /**
     * Get account spam filter keywords.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\CommentFilterKeywordsResponse
     */
    public function getCommentFilterKeywords()
    {
        return $this->ig->request('accounts/get_comment_filter_keywords/')
            ->getResponse(new Response\CommentFilterKeywordsResponse());
    }

    /**
     * Set account spam filter keywords.
     *
     * @param string $keywords List of blocked words, separated by comma.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\CommentFilterSetResponse
     */
    public function setCommentFilterKeywords(
        $keywords)
    {
        return $this->ig->request('accounts/set_comment_filter_keywords/')
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->addPost('keywords', $keywords)
            ->getResponse(new Response\CommentFilterSetResponse());
    }

    /**
     * Change your account's password.
     *
     * @param string $oldPassword Old password.
     * @param string $newPassword New password.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\ChangePasswordResponse
     */
    public function changePassword(
        $oldPassword,
        $newPassword)
    {
        return $this->ig->request('accounts/change_password/')
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->addPost('old_password', $oldPassword)
            ->addPost('new_password1', $newPassword)
            ->addPost('new_password2', $newPassword)
            ->getResponse(new Response\ChangePasswordResponse());
    }

    /**
     * Get account security info and backup codes.
     *
     * WARNING: STORE AND KEEP BACKUP CODES IN A SAFE PLACE. THEY ARE EXTREMELY
     *          IMPORTANT! YOU WILL GET THE CODES IN THE RESPONSE. THE BACKUP
     *          CODES LET YOU REGAIN CONTROL OF YOUR ACCOUNT IF YOU LOSE THE
     *          PHONE NUMBER! WITHOUT THE CODES, YOU RISK LOSING YOUR ACCOUNT!
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\AccountSecurityInfoResponse
     *
     * @see Account::enableTwoFactorSMS()
     */
    public function getSecurityInfo()
    {
        return $this->ig->request('accounts/account_security_info/')
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->getResponse(new Response\AccountSecurityInfoResponse());
    }

    /**
     * Request that Instagram enables two factor SMS authentication.
     *
     * The SMS will have a verification code for enabling two factor SMS
     * authentication. You must then give that code to enableTwoFactorSMS().
     *
     * @param string $phoneNumber Phone number with country code. Format: +34123456789.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\RequestTwoFactorResponse
     *
     * @see Account::enableTwoFactorSMS()
     */
    public function requestTwoFactorSMS(
        $phoneNumber)
    {
        $cleanNumber = '+'.preg_replace('/[^0-9]/', '', $phoneNumber);

        return $this->ig->request('accounts/send_two_factor_enable_sms/')
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->addPost('device_id', $this->ig->device_id)
            ->addPost('phone_number', $cleanNumber)
            ->getResponse(new Response\RequestTwoFactorResponse());
    }

    /**
     * Enable Two Factor authentication.
     *
     * WARNING: STORE AND KEEP BACKUP CODES IN A SAFE PLACE. THEY ARE EXTREMELY
     *          IMPORTANT! YOU WILL GET THE CODES IN THE RESPONSE. THE BACKUP
     *          CODES LET YOU REGAIN CONTROL OF YOUR ACCOUNT IF YOU LOSE THE
     *          PHONE NUMBER! WITHOUT THE CODES, YOU RISK LOSING YOUR ACCOUNT!
     *
     * @param string $phoneNumber      Phone number with country code. Format: +34123456789.
     * @param string $verificationCode The code sent to your phone via Account::requestTwoFactorSMS().
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\AccountSecurityInfoResponse
     *
     * @see Account::requestTwoFactorSMS()
     * @see Account::getSecurityInfo()
     */
    public function enableTwoFactorSMS(
        $phoneNumber,
        $verificationCode)
    {
        $cleanNumber = '+'.preg_replace('/[^0-9]/', '', $phoneNumber);

        $response = $this->ig->request('accounts/enable_sms_two_factor/')
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->addPost('device_id', $this->ig->device_id)
            ->addPost('phone_number', $cleanNumber)
            ->addPost('verification_code', $verificationCode)
            ->getResponse(new Response\EnableTwoFactorResponse());

        return $this->getSecurityInfo();
    }

    /**
     * Disable Two Factor authentication.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\DisableTwoFactorResponse
     */
    public function disableTwoFactorSMS()
    {
        return $this->ig->request('accounts/disable_sms_two_factor/')
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->getResponse(new Response\DisableTwoFactorResponse());
    }

    /**
     * Tell Instagram to send you a message to verify your email address.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\SendConfirmEmailResponse
     */
    public function sendConfirmEmail()
    {
        return $this->ig->request('accounts/send_confirm_email/')
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('send_source', 'profile_megaphone')
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->getResponse(new Response\SendConfirmEmailResponse());
    }

    /**
     * Get account badge notifications.
     *
     * TODO: We have no idea what this does. The response is always empty.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\BadgeNotificationsResponse
     */
    public function getBadgeNotifications()
    {
        return $this->ig->request('notifications/badge/')
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->addPost('users_ids', $this->ig->account_id)
            ->addPost('device_id', $this->ig->device_id)
            ->getResponse(new Response\BadgeNotificationsResponse());
    }
}
