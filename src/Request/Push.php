<?php

namespace InstagramAPI\Request;

use InstagramAPI\Response;

/**
 * Functions for managing your push notifications.
 */
class Push extends RequestCollection
{
    /**
     * Register to the MQTT push server.
     *
     * @param $gcmToken
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\PushRegisterResponse
     */
    public function register(
        $gcmToken)
    {
        $deviceToken = json_encode([
            'k' => $gcmToken,
            'v' => 0,
            't' => 'fbns-b64',
        ]);

        return $this->ig->request('push/register/')
            ->addParam('platform', '10')
            ->addParam('device_type', 'android_mqtt')
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('guid', $this->ig->uuid)
            ->addPost('phone_id', $this->ig->settings->get('phone_id'))
            ->addPost('device_type', 'android_mqtt')
            ->addPost('device_token', $deviceToken)
            ->addPost('is_main_push_channel', true)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->addPost('users', $this->ig->account_id)
            ->getResponse(new Response\PushRegisterResponse());
    }

    /**
     * Get push preferences.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\PushPreferencesResponse
     */
    public function getPreferences()
    {
        return $this->ig->request('push/all_preferences/')
            ->getResponse(new Response\PushPreferencesResponse());
    }

    /**
     * Set push preferences.
     *
     * @param array $preferences Described in "extradocs/Push_setPreferences.txt".
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\PushPreferencesResponse
     */
    public function setPreferences(
        array $preferences)
    {
        $request = $this->ig->request('push/preferences/');
        foreach ($preferences as $key => $value) {
            $request->addPost($key, $value);
        }
        $request->getResponse(new Response\PushPreferencesResponse());
    }
}
