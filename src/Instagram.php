<?php

namespace InstagramAPI;

/**
 * Instagram's Private API v3.
 *
 * TERMS OF USE:
 * - This code is in no way affiliated with, authorized, maintained, sponsored
 *   or endorsed by Instagram or any of its affiliates or subsidiaries. This is
 *   an independent and unofficial API. Use at your own risk.
 * - We do NOT support or tolerate anyone who wants to use this API to send spam
 *   or commit other online crimes.
 * - You will NOT use this API for marketing or other abusive purposes (spam,
 *   botting, harassment, massive bulk messaging...).
 *
 * @author mgp25: Founder, Reversing, Project Leader (https://github.com/mgp25)
 * @author SteveJobzniak (https://github.com/SteveJobzniak)
 */
class Instagram
{
    /**
     * Experiments refresh interval in sec.
     *
     * @var int
     */
    const EXPERIMENTS_REFRESH = 7200;

    /**
     * Currently active Instagram username.
     *
     * @var string
     */
    public $username;

    /**
     * Currently active Instagram password.
     *
     * @var string
     */
    public $password;

    /**
     * The Android Device for the currently active user.
     *
     * @var \InstagramAPI\Devices\Device
     */
    public $device;

    /**
     * Toggles API query/response debug output.
     *
     * @var bool
     */
    public $debug;

    /**
     * Toggles truncating long responses when debugging.
     *
     * @var bool
     */
    public $truncatedDebug;

    /**
     * For internal use by Instagram-API developers!
     *
     * Toggles the throwing of exceptions whenever Instagram-API's "Response"
     * classes lack fields that were provided by the server. Useful for
     * discovering that our library classes need updating.
     *
     * This is only settable via this public property and is NOT meant for
     * end-users of this library. It is for contributing developers!
     *
     * @var bool
     */
    public $apiDeveloperDebug = false;

    /**
     * UUID.
     *
     * @var string
     */
    public $uuid;

    /**
     * Google Play Advertising ID.
     *
     * The advertising ID is a unique ID for advertising, provided by Google
     * Play services for use in Google Play apps. Used by Instagram.
     *
     * @var string
     *
     * @see https://support.google.com/googleplay/android-developer/answer/6048248?hl=en
     */
    public $advertising_id;

    /**
     * Device ID.
     *
     * @var string
     */
    public $device_id;

    /**
     * Numerical UserPK ID of the active user account.
     *
     * @var string
     */
    public $account_id;

    /**
     * Session status.
     *
     * @var bool
     */
    public $isLoggedIn = false;

    /**
     * Rank token.
     *
     * @var string
     */
    public $rank_token;

    /**
     * Raw API communication/networking class.
     *
     * @var Client
     */
    public $client;

    /**
     * The account settings storage.
     *
     * @var \InstagramAPI\Settings\StorageHandler|null
     */
    public $settings;

    /**
     * A list of experiments enabled on per-account basis.
     *
     * @var array
     */
    public $experiments;

    /** @var Request\Account Collection of Account related functions. */
    public $account;
    /** @var Request\Business Collection of Business related functions. */
    public $business;
    /** @var Request\Creative Collection of Creative related functions. */
    public $creative;
    /** @var Request\Direct Collection of Direct related functions. */
    public $direct;
    /** @var Request\Discover Collection of Discover related functions. */
    public $discover;
    /** @var Request\Hashtag Collection of Hashtag related functions. */
    public $hashtag;
    /** @var Request\Internal Collection of Internal (non-public) functions. */
    public $internal;
    /** @var Request\Live Collection of Live related functions. */
    public $live;
    /** @var Request\Location Collection of Location related functions. */
    public $location;
    /** @var Request\Media Collection of Media related functions. */
    public $media;
    /** @var Request\People Collection of People related functions. */
    public $people;
    /** @var Request\Push Collection of Push related functions. */
    public $push;
    /** @var Request\Story Collection of Story related functions. */
    public $story;
    /** @var Request\Timeline Collection of Timeline related functions. */
    public $timeline;
    /** @var Request\Usertag Collection of Usertag related functions. */
    public $usertag;

    /**
     * Constructor.
     *
     * @param bool  $debug          Show API queries and responses.
     * @param bool  $truncatedDebug Truncate long responses in debug.
     * @param array $storageConfig  Configuration for the desired
     *                              user settings storage backend.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     */
    public function __construct(
        $debug = false,
        $truncatedDebug = false,
        $storageConfig = [])
    {
        // Debugging options.
        $this->debug = $debug;
        $this->truncatedDebug = $truncatedDebug;

        // Load all function collections.
        $this->account = new Request\Account($this);
        $this->business = new Request\Business($this);
        $this->creative = new Request\Creative($this);
        $this->direct = new Request\Direct($this);
        $this->discover = new Request\Discover($this);
        $this->hashtag = new Request\Hashtag($this);
        $this->internal = new Request\Internal($this);
        $this->live = new Request\Live($this);
        $this->location = new Request\Location($this);
        $this->media = new Request\Media($this);
        $this->people = new Request\People($this);
        $this->push = new Request\Push($this);
        $this->story = new Request\Story($this);
        $this->timeline = new Request\Timeline($this);
        $this->usertag = new Request\Usertag($this);

        // Configure the settings storage and network client.
        $self = $this;
        $this->settings = Settings\Factory::createHandler(
            $storageConfig,
            [
                // This saves all user session cookies "in bulk" at script exit
                // or when switching to a different user, so that it only needs
                // to write cookies to storage a few times per user session:
                'onCloseUser' => function ($storage) use ($self) {
                    if ($self->client instanceof Client) {
                        $self->client->saveCookieJar();
                    }
                },
            ]
        );
        $this->client = new Client($this);
        $this->experiments = [];
    }

    /**
     * Controls the SSL verification behavior of the Client.
     *
     * @see http://docs.guzzlephp.org/en/latest/request-options.html#verify
     *
     * @param bool|string $state TRUE to verify using PHP's default CA bundle,
     *                           FALSE to disable SSL verification (this is
     *                           insecure!), String to verify using this path to
     *                           a custom CA bundle file.
     */
    public function setVerifySSL(
        $state)
    {
        $this->client->setVerifySSL($state);
    }

    /**
     * Gets the current SSL verification behavior of the Client.
     *
     * @return bool|string
     */
    public function getVerifySSL()
    {
        return $this->client->getVerifySSL();
    }

    /**
     * Set the proxy to use for requests.
     *
     * @see http://docs.guzzlephp.org/en/latest/request-options.html#proxy
     *
     * @param string|array|null $value String or Array specifying a proxy in
     *                                 Guzzle format, or NULL to disable proxying.
     */
    public function setProxy(
        $value)
    {
        $this->client->setProxy($value);
    }

    /**
     * Gets the current proxy used for requests.
     *
     * @return string|array|null
     */
    public function getProxy()
    {
        return $this->client->getProxy();
    }

    /**
     * Sets the network interface override to use.
     *
     * Only works if Guzzle is using the cURL backend. But that's
     * almost always the case, on most PHP installations.
     *
     * @see http://php.net/curl_setopt CURLOPT_INTERFACE
     *
     * @var string|null Interface name, IP address or hostname, or NULL to
     *                  disable override and let Guzzle use any interface.
     */
    public function setOutputInterface(
        $value)
    {
        $this->client->setOutputInterface($value);
    }

    /**
     * Gets the current network interface override used for requests.
     *
     * @return string|null
     */
    public function getOutputInterface()
    {
        return $this->client->getOutputInterface();
    }

    /**
     * Set the active account for the class instance.
     *
     * You can call this multiple times to switch between multiple accounts.
     *
     * @param string $username Your Instagram username.
     * @param string $password Your Instagram password.
     *
     * @throws \InvalidArgumentException
     * @throws \InstagramAPI\Exception\InstagramException
     */
    public function setUser(
        $username,
        $password)
    {
        if (empty($username) || empty($password)) {
            throw new \InvalidArgumentException('You must provide a username and password to setUser().');
        }

        // Load all settings from the storage and mark as current user.
        $this->settings->setActiveUser($username);

        // Generate the user's Device instance, which will be created from the
        // user's last-used device IF they've got a valid, good one stored.
        // But if they've got a BAD/none, this will create a brand-new device.
        $savedDeviceString = $this->settings->get('devicestring');
        $this->device = new Devices\Device(Constants::IG_VERSION, Constants::USER_AGENT_LOCALE, $savedDeviceString);

        // Save the chosen device string to settings if not already stored.
        $deviceString = $this->device->getDeviceString();
        if ($deviceString !== $savedDeviceString) {
            $this->settings->set('devicestring', $deviceString);
        }

        // Generate a brand-new device fingerprint if the Device wasn't reused
        // from settings, OR if any of the stored fingerprints are missing.
        // NOTE: The regeneration when our device model changes is to avoid
        // dangerously reusing the "previous phone's" unique hardware IDs.
        // WARNING TO CONTRIBUTORS: Only add new parameter-checks here if they
        // are CRITICALLY important to the particular device. We don't want to
        // frivolously force the users to generate new device IDs constantly.
        $resetCookieJar = false;
        if ($deviceString !== $savedDeviceString // Brand new device, or missing
            || empty($this->settings->get('uuid')) // one of the critically...
            || empty($this->settings->get('phone_id')) // ...important device...
            || empty($this->settings->get('device_id'))) { // ...parameters.
            // Generate new hardware fingerprints.
            $this->settings->set('device_id', Signatures::generateDeviceId());
            $this->settings->set('phone_id', Signatures::generateUUID(true));
            $this->settings->set('uuid', Signatures::generateUUID(true));

            // Clear other params we also need to regenerate for the new device.
            $this->settings->set('advertising_id', '');
            $this->settings->set('experiments', '');

            // Remove the previous hardware's login details to force a relogin.
            $this->settings->set('account_id', '');
            $this->settings->set('last_login', '0');

            // We'll also need to throw out all previous cookies.
            $resetCookieJar = true;
        }

        // Generate other missing values. These are for less critical parameters
        // that don't need to trigger a complete device reset like above. For
        // example, this is good for new parameters that Instagram introduces
        // over time, since those can be added one-by-one over time without
        // needing to wipe/reset the whole device. Just be sure to also add them
        // to the "clear other params" section above so that these are always
        // properly regenerated whenever the user's whole "device" changes.
        if (empty($this->settings->get('advertising_id'))) {
            $this->settings->set('advertising_id', Signatures::generateUUID(true));
        }

        // Store various important parameters for easy access.
        $this->username = $username;
        $this->password = $password;
        $this->uuid = $this->settings->get('uuid');
        $this->advertising_id = $this->settings->get('advertising_id');
        $this->device_id = $this->settings->get('device_id');
        $this->experiments = $this->settings->getExperiments();

        // Load the previous session details if we're possibly logged in.
        if (!$resetCookieJar && $this->settings->isMaybeLoggedIn()) {
            $this->isLoggedIn = true;
            $this->account_id = $this->settings->get('account_id');
            $this->rank_token = $this->account_id.'_'.$this->uuid;
        } else {
            $this->isLoggedIn = false;
            $this->account_id = null;
            $this->rank_token = null;
        }

        // Configures Client for current user AND updates isLoggedIn state
        // if it fails to load the expected cookies from the user's jar.
        // Must be done last here, so that isLoggedIn is properly updated!
        // NOTE: If we generated a new device we start a new cookie jar.
        $this->client->updateFromCurrentSettings($resetCookieJar);
    }

    /**
     * Login to Instagram or automatically resume and refresh previous session.
     *
     * WARNING: You MUST run this function EVERY time your script runs! It handles automatic session
     * resume and relogin and app session state refresh and other absolutely *vital* things that are
     * important if you don't want to be banned from Instagram!
     *
     * @param bool $forceLogin         Force login to Instagram, this will create a new session.
     * @param int  $appRefreshInterval How frequently login() should act like an Instagram app
     *                                 that's been closed and reopened and needs to "refresh its
     *                                 state", by asking for extended account state details.
     *                                 Default: After 1800 seconds, meaning 30 minutes since the
     *                                 last state-refreshing login() call.
     *                                 This CANNOT be longer than 6 hours. Read _sendLoginFlow()!
     *                                 The shorter your delay is the BETTER. You may even want to
     *                                 set it to an even LOWER value than the default 30 minutes!
     *
     * @throws \InvalidArgumentException
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\LoginResponse|null A login response if a full (re-)login happens,
     *                                                   otherwise NULL if an existing session is resumed.
     */
    public function login(
        $forceLogin = false,
        $appRefreshInterval = 1800)
    {
        if (empty($this->username)) {
            throw new \InstagramAPI\Exception\LoginRequiredException(
                'You must provide a username and password to setUser() before attempting to login.'
            );
        }

        // Perform a full relogin if necessary.
        if (!$this->isLoggedIn || $forceLogin) {
            $this->internal->syncFeatures(true);

            // Call log attribution API so a csrftoken is put in our cookie jar.
            $this->internal->logAttribution();

            try {
                $response = $this->request('accounts/login/')
                    ->setNeedsAuth(false)
                    ->addPost('phone_id', $this->settings->get('phone_id'))
                    ->addPost('_csrftoken', $this->client->getToken())
                    ->addPost('username', $this->username)
                    ->addPost('guid', $this->uuid)
                    ->addPost('adid', $this->advertising_id)
                    ->addPost('device_id', $this->device_id)
                    ->addPost('password', $this->password)
                    ->addPost('login_attempt_count', 0)
                    ->getResponse(new Response\LoginResponse());
            } catch (\InstagramAPI\Exception\InstagramException $e) {
                if ($e->hasResponse() && $e->getResponse()->getTwoFactorRequired()) {
                    // Login failed because two-factor login is required.
                    // Return server response to tell user they need 2-factor.
                    return $e->getResponse();
                } else {
                    // Login failed for some other reason... Re-throw error.
                    throw $e;
                }
            }

            $this->_updateLoginState($response);

            $this->_sendLoginFlow(true, $appRefreshInterval);

            // Full (re-)login successfully completed. Return server response.
            return $response;
        }

        // Attempt to resume an existing session, or full re-login if necessary.
        // NOTE: The "return" here gives a LoginResponse in case of re-login.
        return $this->_sendLoginFlow(false, $appRefreshInterval);
    }

    /**
     * Login to Instagram using two factor authentication.
     *
     * @param string $verificationCode    Verification code you have received via SMS.
     * @param string $twoFactorIdentifier Two factor identifier, obtained in login() response. Format: 123456.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\LoginResponse
     */
    public function twoFactorLogin(
        $verificationCode,
        $twoFactorIdentifier)
    {
        if (empty($this->username)) {
            throw new \InstagramAPI\Exception\LoginRequiredException(
                'You must provide a username and password to setUser() before attempting to login.'
            );
        }

        $verificationCode = trim(str_replace(' ', '', $verificationCode));

        $response = $this->request('accounts/two_factor_login/')
            ->setNeedsAuth(false)
            ->addPost('verification_code', $verificationCode)
            ->addPost('two_factor_identifier', $twoFactorIdentifier)
            ->addPost('_csrftoken', $this->client->getToken())
            ->addPost('username', $this->username)
            ->addPost('device_id', $this->device_id)
            ->addPost('password', $this->password)
            ->getResponse(new Response\LoginResponse());

        $this->_updateLoginState($response);

        $this->_sendLoginFlow(true);

        return $response;
    }

    /**
     * Updates the internal state after a successful login.
     *
     * @param Response\LoginResponse $response The login response.
     *
     * @throws \InvalidArgumentException
     * @throws \InstagramAPI\Exception\InstagramException
     */
    protected function _updateLoginState(
        Response\LoginResponse $response)
    {
        // This check is just protection against accidental bugs. It makes sure
        // that we always call this function with a *successful* login response!
        if (!$response instanceof Response\LoginResponse
            || !$response->isOk()) {
            throw new \InvalidArgumentException('Invalid login response provided to _updateLoginState().');
        }

        $this->isLoggedIn = true;
        $this->account_id = $response->getLoggedInUser()->getPk();
        $this->settings->set('account_id', $this->account_id);
        $this->rank_token = $this->account_id.'_'.$this->uuid;
        $this->settings->set('last_login', time());
    }

    /**
     * Sends login flow. This is required to emulate real device behavior.
     *
     * @param bool $justLoggedIn
     * @param int  $appRefreshInterval
     *
     * @throws \InvalidArgumentException
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\LoginResponse|null A login response if a full (re-)login is needed
     *                                                   during the login flow attempt, otherwise NULL.
     */
    protected function _sendLoginFlow(
        $justLoggedIn,
        $appRefreshInterval = 1800)
    {
        if ($appRefreshInterval > 21600) {
            throw new \InvalidArgumentException("Instagram's app state refresh interval is NOT allowed to be higher than 6 hours, and the lower the better!");
        }

        // SUPER IMPORTANT:
        //
        // STOP trying to ask us to remove this code section!
        //
        // EVERY time the user presses their device's home button to leave the
        // app and then comes back to the app, Instagram does ALL of these things
        // to refresh its internal app state. We MUST emulate that perfectly,
        // otherwise Instagram will silently detect you as a "fake" client
        // after a while!
        //
        // You can configure the login's $appRefreshInterval in the function
        // parameter above, but you should keep it VERY frequent (definitely
        // NEVER longer than 6 hours), so that Instagram sees you as a real
        // client that keeps quitting and opening their app like a REAL user!
        //
        // Otherwise they WILL detect you as a bot and silently BLOCK features
        // or even ban you.
        //
        // You have been warned.
        if ($justLoggedIn) {
            // Perform the "user has just done a full login" API flow.
            $this->internal->syncFeatures();
            $this->people->getAutoCompleteUserList();
            $this->story->getReelsTrayFeed();
            $this->direct->getRecentRecipients();
            $this->timeline->getTimelineFeed();
            //push register
            $this->direct->getRankedRecipients('reshare', true);
            $this->direct->getRankedRecipients('raven', true);
            $this->direct->getInbox();
            $this->direct->getVisualInbox();
            //$this->internal->getMegaphoneLog();
            $this->people->getRecentActivityInbox();
            $this->internal->getProfileNotice();
            $this->media->getBlockedMedia();
            $this->discover->getExploreFeed();
            //$this->internal->getFacebookOTA();
        } else {
            // Act like a real logged in app client refreshing its news timeline.
            // This also lets us detect if we're still logged in with a valid session.
            try {
                $this->timeline->getTimelineFeed();
            } catch (\InstagramAPI\Exception\LoginRequiredException $e) {
                // If our session cookies are expired, we were now told to login,
                // so handle that by running a forced relogin in that case!
                return $this->login(true, $appRefreshInterval);
            }

            // Perform the "user has returned to their already-logged in app,
            // so refresh all feeds to check for news" API flow.
            $lastLoginTime = $this->settings->get('last_login');
            if (is_null($lastLoginTime) || (time() - $lastLoginTime) > $appRefreshInterval) {
                $this->settings->set('last_login', time());

                $this->people->getAutoCompleteUserList();
                $this->story->getReelsTrayFeed();
                $this->direct->getRankedRecipients('reshare', true);
                $this->direct->getRankedRecipients('raven', true);
                //push register
                $this->direct->getRecentRecipients();
                //push register
                //$this->internal->getMegaphoneLog();
                $this->direct->getInbox();
                $this->people->getRecentActivityInbox();
                $this->internal->getProfileNotice();
                $this->discover->getExploreFeed();
            }

            // Users normally resume their sessions, meaning that their
            // experiments never get synced and updated. So sync periodically.
            $lastExperimentsTime = $this->settings->get('last_experiments');
            if (is_null($lastExperimentsTime) || (time() - $lastExperimentsTime) > self::EXPERIMENTS_REFRESH) {
                $this->internal->syncFeatures();
            }
        }

        // We've now performed a login or resumed a session. Forcibly write our
        // cookies to the storage, to ensure that the storage doesn't miss them
        // in case something bad happens to PHP after this moment.
        $this->client->saveCookieJar();
    }

    /**
     * Log out of Instagram.
     *
     * WARNING: Most people should NEVER call logout()! Our library emulates
     * the Instagram app for Android, where you are supposed to stay logged in
     * forever. By calling this function, you will tell Instagram that you are
     * logging out of the APP. But you shouldn't do that! In almost 100% of all
     * cases you want to *stay logged in* so that LOGIN() resumes your session!
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\LogoutResponse
     *
     * @see Instagram::login()
     */
    public function logout()
    {
        $response = $this->request('accounts/logout/')
            ->getResponse(new Response\LogoutResponse());

        // We've now logged out. Forcibly write our cookies to the storage, to
        // ensure that the storage doesn't miss them in case something bad
        // happens to PHP after this moment.
        $this->client->saveCookieJar();

        return $response;
    }

    /**
     * Checks if a parameter is enabled in the given experiment.
     *
     * @param string $experiment
     * @param string $param
     *
     * @return bool
     */
    public function isExperimentEnabled(
        $experiment,
        $param)
    {
        return isset($this->experiments[$experiment][$param])
            && in_array($this->experiments[$experiment][$param], ['enabled', 'true', '1']);
    }

    /**
     * Create a custom API request.
     *
     * Used internally, but can also be used by end-users if they want
     * to create completely custom API queries without modifying this library.
     *
     * @param string $url
     *
     * @return \InstagramAPI\Request
     */
    public function request(
        $url)
    {
        return new Request($this, $url);
    }
}
