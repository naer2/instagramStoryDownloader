<?php

namespace InstagramAPI;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\HandlerStack;
use InstagramAPI\Exception\ServerMessageThrower;
use InstagramAPI\Exception\SettingsException;

/**
 * This class handles core API network communication and file uploads.
 *
 * WARNING TO CONTRIBUTORS: Do NOT build ANY monolithic multi-step functions
 * within this class! Every function here MUST be a tiny, individual unit of
 * work, such as "request upload URL" or "upload data to a URL". NOT "request
 * upload URL, upload data, configure its location, post it to a timeline, call
 * your grandmother and make some tea". Because that would be unmaintainable and
 * would lock us into unmodifiable, bloated behaviors!
 *
 * Such larger multi-step algorithms MUST be implemented in Instagram.php
 * instead, and MUST simply use individual functions from this class to
 * accomplish their larger jobs.
 *
 * Thank you, for not writing spaghetti code! ;-)
 *
 * @author mgp25: Founder, Reversing, Project Leader (https://github.com/mgp25)
 * @author SteveJobzniak (https://github.com/SteveJobzniak)
 */
class Client
{
    /**
     * How frequently we're allowed to auto-save the cookie jar, in seconds.
     *
     * @var int
     */
    const COOKIE_AUTOSAVE_INTERVAL = 45;

    /**
     * The Instagram class instance we belong to.
     *
     * @var \InstagramAPI\Instagram
     */
    protected $_parent;

    /**
     * What user agent to identify our client as.
     *
     * @var string
     */
    protected $_userAgent;

    /**
     * The SSL certificate verification behavior of requests.
     *
     * @see http://docs.guzzlephp.org/en/latest/request-options.html#verify
     *
     * @var bool|string
     */
    protected $_verifySSL;

    /**
     * Proxy to use for all requests. Optional.
     *
     * @see http://docs.guzzlephp.org/en/latest/request-options.html#proxy
     *
     * @var string|array|null
     */
    protected $_proxy;

    /**
     * Network interface override to use.
     *
     * Only works if Guzzle is using the cURL backend. But that's
     * almost always the case, on most PHP installations.
     *
     * @see http://php.net/curl_setopt CURLOPT_INTERFACE
     *
     * @var string|null
     */
    protected $_outputInterface;

    /**
     * @var \GuzzleHttp\Client
     */
    private $_guzzleClient;

    /**
     * @var \InstagramAPI\ClientMiddleware
     */
    private $_clientMiddleware;

    /**
     * @var \GuzzleHttp\Cookie\CookieJar
     */
    private $_cookieJar;

    /**
     * The cookie format expected by the current settings storage.
     *
     * @var string
     */
    private $_settingsCookieFormat;

    /**
     * The disk path for file-based cookie jars.
     *
     * Only used when the cookieformat is set to "cookiefile".
     *
     * @var string|null
     */
    private $_settingsCookieFilePath;

    /**
     * The timestamp of when we last saved our cookie jar to disk.
     *
     * Used for automatically saving the jar after any API call, after enough
     * time has elapsed since our last save.
     *
     * @var int
     */
    private $_settingsCookieLastSaved;

    /**
     * Our JSON object mapper instance.
     *
     * This object must be globally preserved and always re-used, so that its
     * runtime class analysis cache stays in memory, otherwise it wastes time
     * analyzing our class source code every time it has to map a class again.
     *
     * @var \JsonMapper
     */
    private $_mapper;

    /**
     * Constructor.
     *
     * @param \InstagramAPI\Instagram $parent
     */
    public function __construct(
        $parent)
    {
        $this->_parent = $parent;

        // Defaults.
        $this->_verifySSL = true;
        $this->_proxy = null;

        // Create a default handler stack with Guzzle's auto-selected "best
        // possible transfer handler for the user's system", and with all of
        // Guzzle's default middleware (cookie jar support, etc).
        $stack = HandlerStack::create();

        // Create our custom Guzzle client middleware and add it to the stack.
        $this->_clientMiddleware = new ClientMiddleware();
        $stack->push($this->_clientMiddleware);

        // Default request options (immutable after client creation).
        $this->_guzzleClient = new GuzzleClient([
            'handler'         => $stack, // Our middleware is now injected.
            'allow_redirects' => [
                'max' => 8, // Allow up to eight redirects (that's plenty).
            ],
            'connect_timeout' => 30.0, // Give up trying to connect after 30s.
            'decode_content'  => true, // Decode gzip/deflate/etc HTTP responses.
            'timeout'         => 240.0, // Maximum per-request time (seconds).
            // Tells Guzzle to stop throwing exceptions on non-"2xx" HTTP codes,
            // thus ensuring that it only triggers exceptions on socket errors!
            // We'll instead MANUALLY be throwing on certain other HTTP codes.
            'http_errors'     => false,
        ]);

        // Create our JSON object mapper and set global default options.
        $this->_mapper = new \JsonMapper();
        $this->_mapper->bStrictNullTypes = false; // Allow NULL values.
    }

    /**
     * Resets certain Client settings via the current Settings storage.
     *
     * Used whenever the user switches setUser(), to configure our internal state.
     *
     * @param bool $resetCookieJar (optional) Whether to clear current cookies.
     *
     * @throws \InstagramAPI\Exception\SettingsException
     */
    public function updateFromCurrentSettings(
        $resetCookieJar = false)
    {
        // Update our internal client state from the new user's settings.
        $this->_userAgent = $this->_parent->device->getUserAgent();
        $this->loadCookieJar($resetCookieJar);

        // Verify that the jar contains a non-expired csrftoken for the API
        // domain. Instagram gives us a 1-year csrftoken whenever we log in.
        // If it's missing, we're definitely NOT logged in! But even if all of
        // these checks succeed, the cookie may still not be valid. It's just a
        // preliminary check to detect definitely-invalid session cookies!
        if ($this->getToken() === null) {
            $this->_parent->isLoggedIn = false;
        }
    }

    /**
     * Loads all cookies via the current Settings storage.
     *
     * @param bool $resetCookieJar (optional) Whether to clear current cookies.
     *
     * @throws \InstagramAPI\Exception\SettingsException
     */
    public function loadCookieJar(
        $resetCookieJar = false)
    {
        // Mark any previous cookie jar for garbage collection.
        $this->_cookieJar = null;

        // Get all cookies for the currently active user.
        $userCookies = $this->_parent->settings->getCookies();
        $this->_settingsCookieFormat = $userCookies['format'];
        $this->_settingsCookieFilePath = null;

        // Get the raw cookie string from the storage backend.
        $cookieString = '';
        if ($userCookies['format'] == 'cookiefile') {
            $this->_settingsCookieFilePath = $userCookies['data'];
            if (empty($this->_settingsCookieFilePath)) {
                throw new SettingsException(
                    'Cookie file format requested, but no file path provided.'
                );
            }

            // Ensure that the whole directory path to the cookie file exists.
            $cookieDir = dirname($this->_settingsCookieFilePath); // Can be "." in case of CWD.
            if (!Utils::createFolder($cookieDir)) {
                throw new SettingsException(sprintf(
                    'The "%s" cookie folder is not writable.',
                    $cookieDir
                ));
            }

            // Process the existing cookie jar file if it already exists.
            if (is_file($this->_settingsCookieFilePath)) {
                if ($resetCookieJar) {
                    // Delete existing cookie jar since this is a reset.
                    @unlink($this->_settingsCookieFilePath);
                } else {
                    // Read the existing cookies from disk.
                    $rawData = file_get_contents($this->_settingsCookieFilePath);
                    if ($rawData !== false) {
                        $cookieString = $rawData;
                    }
                }
            }
        } else {
            // Delete existing cookie data from the storage if this is a reset.
            if ($resetCookieJar) {
                $userCookies['data'] = '';
                $this->_parent->settings->setCookies('');
            }

            // Read the existing cookies provided by the storage.
            $cookieString = $userCookies['data'];
        }

        // Attempt to restore the cookies, otherwise create a new, empty jar.
        $restoredCookies = @json_decode($cookieString, true);
        if (!is_array($restoredCookies)) {
            $restoredCookies = [];
        }

        // Memory-based cookie jar which must be manually saved later.
        $this->_cookieJar = new CookieJar(false, $restoredCookies);

        // Reset the "last saved" timestamp to the current time to prevent
        // auto-saving the cookies again immediately after this jar is loaded.
        $this->_settingsCookieLastSaved = time();
    }

    /**
     * Retrieve the CSRF token from the current cookie jar.
     *
     * Note that Instagram gives you a 1-year token expiration timestamp when
     * you log in. But if you log out, they set its timestamp to "0" which means
     * that the cookie is "expired" and invalid. We ignore token cookies if they
     * have been logged out, or if they have expired naturally.
     *
     * @return string|null The token if found and non-expired, otherwise NULL.
     */
    public function getToken()
    {
        $cookie = $this->getCookie('csrftoken', 'i.instagram.com');
        if ($cookie === null || $cookie->getExpires() <= time()) {
            return; // Ugh, StyleCI doesn't allow "return null;" for clarity. ;)
        }

        return $cookie->getValue();
    }

    /**
     * Searches for a specific cookie in the current jar.
     *
     * @param string      $name   The name of the cookie.
     * @param string|null $domain (optional) Require a specific domain match.
     * @param string|null $path   (optional) Require a specific path match.
     *
     * @return \GuzzleHttp\Cookie\SetCookie|null A cookie if found, otherwise NULL.
     */
    public function getCookie(
        $name,
        $domain = null,
        $path = null)
    {
        $foundCookie = null;
        if ($this->_cookieJar instanceof CookieJar) {
            foreach ($this->_cookieJar->getIterator() as $cookie) {
                if ($cookie->getName() == $name
                    && ($domain === null || $cookie->getDomain() == $domain)
                    && ($path === null || $cookie->getPath() == $path)) {
                    $foundCookie = $cookie;
                    break;
                }
            }
        }

        return $foundCookie;
    }

    /**
     * Gives you all cookies in the Jar encoded as a JSON string.
     *
     * This allows custom Settings storages to retrieve all cookies for saving.
     *
     * @throws \InvalidArgumentException If the JSON cannot be encoded.
     *
     * @return string
     */
    public function getCookieJarAsJSON()
    {
        if (!$this->_cookieJar instanceof CookieJar) {
            return '[]';
        }

        // Gets ALL cookies from the jar, even temporary session-based cookies.
        $cookies = $this->_cookieJar->toArray();

        // Throws if data can't be encoded as JSON (will never happen).
        $jsonStr = \GuzzleHttp\json_encode($cookies);

        return $jsonStr;
    }

    /**
     * Tells current settings storage to store cookies if necessary.
     *
     * NOTE: This Client class is NOT responsible for calling this function!
     * Instead, our parent "Instagram" instance takes care of it and saves the
     * cookies "onCloseUser", so that cookies are written to storage in a
     * single, efficient write when the user's session is finished. We also call
     * it during some important function calls such as login/logout. Client also
     * automatically calls it when enough time has elapsed since last save.
     *
     * @throws \InvalidArgumentException                 If the JSON cannot be encoded.
     * @throws \InstagramAPI\Exception\SettingsException
     */
    public function saveCookieJar()
    {
        $newCookies = $this->getCookieJarAsJSON();
        if ($this->_settingsCookieFormat != 'cookiefile') {
            // Tell non-file settings storage to persist the latest cookies.
            $this->_parent->settings->setCookies($newCookies);
        } else {
            // This is a file-based cookie storage. It's our job to write it.
            if (!empty($this->_settingsCookieFilePath)) {
                // Perform an atomic diskwrite, which prevents accidental
                // truncation if the script is ever interrupted mid-write.
                $written = Utils::atomicWrite($this->_settingsCookieFilePath, $newCookies);
                if ($written === false) {
                    throw new SettingsException(sprintf(
                        'The "%s" cookie file is not writable.',
                        $this->_settingsCookieFilePath
                    ));
                }
            }
        }

        // Reset the "last saved" timestamp to the current time.
        $this->_settingsCookieLastSaved = time();
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
        $this->_verifySSL = $state;
    }

    /**
     * Gets the current SSL verification behavior of the Client.
     *
     * @return bool|string
     */
    public function getVerifySSL()
    {
        return $this->_verifySSL;
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
        $this->_proxy = $value;
    }

    /**
     * Gets the current proxy used for requests.
     *
     * @return string|array|null
     */
    public function getProxy()
    {
        return $this->_proxy;
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
        $this->_outputInterface = $value;
    }

    /**
     * Gets the current network interface override used for requests.
     *
     * @return string|null
     */
    public function getOutputInterface()
    {
        return $this->_outputInterface;
    }

    /**
     * Output debugging information.
     *
     * @param string      $method        "GET" or "POST".
     * @param string      $url           The URL or endpoint used for the request.
     * @param string|null $uploadedBody  What was sent to the server. Use NULL to
     *                                   avoid displaying it.
     * @param int|null    $uploadedBytes How many bytes were uploaded. Use NULL to
     *                                   avoid displaying it.
     * @param object      $response      The Guzzle response object from the request.
     * @param string      $responseBody  The actual text-body reply from the server.
     */
    protected function _printDebug(
        $method,
        $url,
        $uploadedBody,
        $uploadedBytes,
        $response,
        $responseBody)
    {
        Debug::printRequest($method, $url);

        // Display the data body that was uploaded, if provided for debugging.
        // NOTE: Only provide this from functions that submit meaningful BODY data!
        if (is_string($uploadedBody)) {
            Debug::printPostData($uploadedBody);
        }

        // Display the number of bytes uploaded in the data body, if provided for debugging.
        // NOTE: Only provide this from functions that actually upload files!
        if (!is_null($uploadedBytes)) {
            Debug::printUpload(Utils::formatBytes($uploadedBytes));
        }

        // Display the number of bytes received from the response, and status code.
        if ($response->hasHeader('x-encoded-content-length')) {
            $bytes = Utils::formatBytes($response->getHeader('x-encoded-content-length')[0]);
        } else {
            $bytes = Utils::formatBytes($response->getHeader('Content-Length')[0]);
        }
        Debug::printHttpCode($response->getStatusCode(), $bytes);

        // Display the actual API response body.
        Debug::printResponse($responseBody, $this->_parent->truncatedDebug);
    }

    /**
     * Helper which throws an error if not logged in.
     *
     * Remember to ALWAYS call this function at the top of any API request that
     * requires the user to be logged in!
     *
     * @throws \InstagramAPI\Exception\LoginRequiredException
     */
    protected function _throwIfNotLoggedIn()
    {
        // Check the cached login state. May not reflect what will happen on the
        // server. But it's the best we can check without trying the actual request!
        if (!$this->_parent->isLoggedIn) {
            throw new \InstagramAPI\Exception\LoginRequiredException('User not logged in. Please call login() and then try again.');
        }
    }

    /**
     * Converts a server response to a specific kind of result object.
     *
     * @param ResponseInterface $baseClass An instance of a class object whose
     *                                     properties to fill with the response.
     * @param mixed             $response  A decoded JSON response from
     *                                     Instagram's server.
     *
     * @throws \InstagramAPI\Exception\InstagramException In case of invalid or
     *                                                    failed API response.
     *
     * @return ResponseInterface
     */
    public function getMappedResponseObject(
        ResponseInterface $baseClass,
        $response)
    {
        if (is_null($response)) {
            throw new \InstagramAPI\Exception\EmptyResponseException('No response from server. Either a connection or configuration error.');
        }

        // Use API developer debugging? Throws if class lacks properties.
        $this->_mapper->bExceptionOnUndefinedProperty = $this->_parent->apiDeveloperDebug;

        // Perform mapping of all response properties.
        /** @var ResponseInterface $responseObject */
        $responseObject = $this->_mapper->map($response, $baseClass);

        // Save the raw response object as the "getFullResponse()" value.
        $responseObject->setFullResponse($response);

        // Throw an exception if the API response was unsuccessful.
        // NOTE: It will contain the full server response object too, which
        // means that the user can look at the full response details via the
        // exception itself.
        if (!$responseObject->isOk()) {
            if ($responseObject instanceof \InstagramAPI\Response\DirectSendItemResponse && $responseObject->getPayload() !== null) {
                $message = $responseObject->getPayload()->getMessage();
            } else {
                $message = $responseObject->getMessage();
            }
            ServerMessageThrower::autoThrow(
                get_class($baseClass),
                $message,
                $responseObject
            );
        }

        return $responseObject;
    }

    /**
     * Helper which builds in the most important Guzzle options.
     *
     * Takes care of adding all critical options that we need on every request.
     * Such as cookies and the user's proxy. But don't call this function
     * manually. It's automatically called by _guzzleRequest()!
     *
     * @param array $guzzleOptions The options specific to the current request.
     *
     * @return array A guzzle options array.
     */
    protected function _buildGuzzleOptions(
        array $guzzleOptions)
    {
        $criticalOptions = [
            'cookies' => ($this->_cookieJar instanceof CookieJar ? $this->_cookieJar : false),
            'verify'  => $this->_verifySSL,
            'proxy'   => (!is_null($this->_proxy) ? $this->_proxy : null),
        ];

        // Critical options always overwrite identical keys in regular opts.
        // This ensures that we can't screw up the proxy/verify/cookies.
        $finalOptions = array_merge($guzzleOptions, $criticalOptions);

        // Now merge any specific Guzzle cURL-backend overrides. We must do this
        // separately since it's in an associative array and we can't just
        // overwrite that whole array in case the caller had curl options.
        if (!array_key_exists('curl', $finalOptions)) {
            $finalOptions['curl'] = [];
        }

        // Add their network interface override if they want it.
        // This option MUST be non-empty if set, otherwise it breaks cURL.
        if (is_string($this->_outputInterface) && $this->_outputInterface !== '') {
            $finalOptions['curl'][CURLOPT_INTERFACE] = $this->_outputInterface;
        }

        return $finalOptions;
    }

    /**
     * Wraps Guzzle's request and adds special error handling and options.
     *
     * Automatically throws exceptions on certain very serious HTTP errors. And
     * re-wraps all Guzzle errors to our own internal exceptions instead. You
     * must ALWAYS use this (or _apiRequest()) instead of the raw Guzzle Client!
     * However, you can never assume the server response contains what you
     * wanted. Be sure to validate the API reply too, since Instagram's API
     * calls themselves may fail with a JSON message explaining what went wrong.
     *
     * WARNING: This is a semi-lowlevel handler which only applies critical
     * options and HTTP connection handling! Most functions will want to call
     * _apiRequest() instead. An even higher-level handler which takes care of
     * debugging, server response checking and response decoding!
     *
     * @param string $method        HTTP method.
     * @param string $uri           Full URI string.
     * @param array  $guzzleOptions Request options to apply.
     *
     * @throws \InstagramAPI\Exception\NetworkException   For any network/socket related errors.
     * @throws \InstagramAPI\Exception\ThrottledException When we're throttled by server.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function _guzzleRequest(
        $method,
        $uri,
        array $guzzleOptions = [])
    {
        // Add critically important options for authenticating the request.
        $guzzleOptions = $this->_buildGuzzleOptions($guzzleOptions);

        // Attempt the request. Will throw in case of socket errors!
        try {
            $response = $this->_guzzleClient->request($method, $uri, $guzzleOptions);
        } catch (\Exception $e) {
            // Re-wrap Guzzle's exception using our own NetworkException.
            throw new \InstagramAPI\Exception\NetworkException($e);
        }

        // Detect very serious HTTP status codes in the response.
        $httpCode = $response->getStatusCode();
        switch ($httpCode) {
        case 429: // "429 Too Many Requests"
            throw new \InstagramAPI\Exception\ThrottledException('Throttled by Instagram because of too many API requests.');
            break;
        // NOTE: Detecting "404" errors was intended to help us detect when API
        // endpoints change. But it turns out that A) Instagram uses "valid" 404
        // status codes in actual API replies to indicate "user not found" and
        // similar states for various lookup functions. So we can't die on 404,
        // since "404" API calls actually succeeded in most cases. And B) Their
        // API doesn't 404 if you try an invalid endpoint URL. Instead, it just
        // redirects you to their official homepage. So catching 404 is both
        // pointless and harmful. This is a warning to future contributors!
        // ---
        // case 404: // "404 Not Found"
        //     die("The requested URL was not found (\"{$uri}\").");
        //     break;
        }

        // We'll periodically auto-save our cookies at certain intervals. This
        // complements the "onCloseUser" and "login()/logout()" force-saving.
        if ((time() - $this->_settingsCookieLastSaved) > self::COOKIE_AUTOSAVE_INTERVAL) {
            $this->saveCookieJar();
        }

        // The response may still have serious but "valid response" errors, such
        // as "400 Bad Request". But it's up to the CALLER to handle those!
        return $response;
    }

    /**
     * Internal wrapper around _guzzleRequest().
     *
     * This takes care of many common additional tasks needed by our library,
     * so you should try to always use this instead of the raw _guzzleRequest()!
     *
     * Available library options are:
     * - 'noDebug': Can be set to TRUE to forcibly hide debugging output for
     *   this request. The user controls debugging globally, but this is an
     *   override that prevents them from seeing certain requests that you may
     *   not want to trigger debugging (such as perhaps individual steps of a
     *   file upload process). However, debugging SHOULD be allowed in MOST cases!
     *   So only use this feature if you have a very good reason.
     * - 'debugUploadedBody': Set to TRUE to make debugging display the data that
     *   was uploaded in the body of the request. DO NOT use this if your function
     *   uploaded binary data, since printing those bytes would kill the terminal!
     * - 'debugUploadedBytes': Set to TRUE to make debugging display the size of
     *   the uploaded body data. Should ALWAYS be TRUE when uploading binary data.
     * - 'decodeToObject': If this option is provided, it MUST either be an instance
     *   of a new class object, or FALSE to signify that you don't want us to do any
     *   object decoding. Omitting this option entirely is the same as FALSE, but
     *   it is highly recommended to ALWAYS include this option (even if FALSE),
     *   for code clarity about what you intend to do with this function's response!
     *
     * @param string $method         HTTP method ("GET" or "POST").
     * @param int    $apiVersion     The Instagram API version to call (1, 2, etc).
     * @param string $endpoint       Relative API endpoint, such as "upload/photo/",
     *                               but can also be a full URI starting with "http:"
     *                               or "https:", which is then used as-provided
     *                               (and apiVersion will be ignored).
     * @param array  $guzzleOptions  Guzzle request() options to apply to the HTTP request.
     * @param array  $libraryOptions Additional options for controlling Library features
     *                               such as the debugging output and response decoding.
     *
     * @throws \InstagramAPI\Exception\NetworkException   For any network/socket related errors.
     * @throws \InstagramAPI\Exception\ThrottledException When we're throttled by server.
     * @throws \InstagramAPI\Exception\InstagramException When "decodeToObject"
     *                                                    was requested and the
     *                                                    API response was
     *                                                    invalid or failed or
     *                                                    class decode failed.
     * @throws \InvalidArgumentException                  If no object provided.
     *
     * @return array An array with the Guzzle "response" object, and the raw
     *               non-decoded HTTP "body" of the request, and the "object" if
     *               the "decodeToObject" library option was used.
     */
    protected function _apiRequest(
        $method,
        $apiVersion,
        $endpoint,
        array $guzzleOptions = [],
        array $libraryOptions = [])
    {
        // Determine the URI to use (it's either relative to API, or a full URI).
        if (strncmp($endpoint, 'http:', 5) === 0 || strncmp($endpoint, 'https:', 6) === 0) {
            $uri = $endpoint;
        } else {
            $uri = Constants::API_URLS[$apiVersion].$endpoint;
        }

        // Perform the API request and retrieve the raw HTTP response body.
        $guzzleResponse = $this->_guzzleRequest($method, $uri, $guzzleOptions);
        $body = $guzzleResponse->getBody()->getContents();

        // Debugging (must be shown before possible decoding error).
        if ($this->_parent->debug && (!isset($libraryOptions['noDebug']) || !$libraryOptions['noDebug'])) {
            // Determine whether we should display the contents of the UPLOADED body.
            if (isset($libraryOptions['debugUploadedBody']) && $libraryOptions['debugUploadedBody']) {
                $uploadedBody = isset($guzzleOptions['body']) ? $guzzleOptions['body'] : null;
            } else {
                $uploadedBody = null; // Don't display.
            }

            // Determine whether we should display the size of the UPLOADED body.
            if (isset($libraryOptions['debugUploadedBytes']) && $libraryOptions['debugUploadedBytes']) {
                // Calculate the uploaded bytes by looking at request's body size, if it exists.
                $uploadedBytes = isset($guzzleOptions['body']) ? strlen($guzzleOptions['body']) : null;
            } else {
                $uploadedBytes = null; // Don't display.
            }

            $this->_printDebug($method, $endpoint, $uploadedBody, $uploadedBytes, $guzzleResponse, $body);
        }

        // Begin building the result array.
        $result = [
            'response' => $guzzleResponse,
            'body'     => $body,
        ];

        // Perform optional API response decoding and success validation.
        if (isset($libraryOptions['decodeToObject']) && $libraryOptions['decodeToObject'] !== false) {
            if (!is_object($libraryOptions['decodeToObject'])) {
                throw new \InvalidArgumentException('Object decoding requested, but no object instance provided.');
            }

            // Check for API response success and attempt to decode it to the desired class.
            $result['object'] = $this->getMappedResponseObject(
                $libraryOptions['decodeToObject'],
                self::api_body_decode($body) // Important: Special JSON decoder.
            );
        }

        return $result;
    }

    /**
     * Perform an Instagram API call.
     *
     * @param int         $apiVersion The Instagram API version to call (1, 2, etc).
     * @param string      $endpoint   Relative API endpoint, such as "media/seen/",
     *                                but can also be a full URI starting with "http:"
     *                                or "https:", which is then used as-provided
     *                                (and apiVersion will be ignored).
     * @param array       $headers    An associative array of custom request headers.
     *                                They'll take precedence over any clashing defaults.
     * @param string|null $postData   Optional string of POST-parameters, to do a
     *                                POST request instead of a GET.
     * @param bool        $needsAuth  Whether this API call needs authorization.
     * @param bool        $assoc      Whether to decode to associative array,
     *                                otherwise we decode to object.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return mixed An object or associative array.
     */
    public function api(
        $apiVersion,
        $endpoint,
        $headers = [],
        $postData = null,
        $needsAuth = true,
        $assoc = true)
    {
        if ($needsAuth) {
            // Throw if this requires authentication and we're not logged in.
            $this->_throwIfNotLoggedIn();
        }

        // Build request options.
        // NOTE: Custom header overrides are given precedence over defaults.
        $headers = array_merge([
            'User-Agent'            => $this->_userAgent,
            // Keep the API's HTTPS connection alive in Guzzle for future
            // re-use, to greatly speed up all further queries after this.
            'Connection'            => 'keep-alive',
            'Accept'                => '*/*',
            'Accept-Encoding'       => Constants::ACCEPT_ENCODING,
            'X-IG-Capabilities'     => Constants::X_IG_Capabilities,
            'X-IG-Connection-Type'  => Constants::X_IG_Connection_Type,
            'X-IG-Connection-Speed' => mt_rand(1000, 3700).'kbps',
            'X-FB-HTTP-Engine'      => Constants::X_FB_HTTP_Engine,
            'Content-Type'          => Constants::CONTENT_TYPE,
            'Accept-Language'       => Constants::ACCEPT_LANGUAGE,
        ], $headers);
        $options = [
            'headers' => $headers,
        ];
        $method = 'GET';
        if ($postData) {
            $method = 'POST';
            $options['body'] = $postData;
        }
        $isMultipart = isset($headers['Content-Type']) && strpos($headers['Content-Type'], 'multipart/form-data') === 0;

        // Perform the API request.
        $response = $this->_apiRequest(
            $method,
            $apiVersion,
            $endpoint,
            $options,
            [
                'debugUploadedBody'  => !$isMultipart,
                'debugUploadedBytes' => $isMultipart,
                'decodeToObject'     => false,
            ]
        );

        // Manually decode the JSON response, since we didn't request object decoding
        // above. This lets our caller later map it to any object they want (or none).
        return self::api_body_decode($response['body'], $assoc);
    }

    /**
     * Performs a chunked upload of a video file, with support for retries.
     *
     * Note that chunk uploads often get dropped when their server is overloaded
     * at peak hours, which is why the "max attempts" parameter exists. We will
     * try that many times to upload all chunks. The retries will only re-upload
     * the exact chunks that have been dropped from their server, and it won't
     * waste time with chunks that are already successfully uploaded.
     *
     * @param string $targetFeed    Target feed for this media ("timeline", "story", "album" or "direct_v2").
     * @param string $videoFilename The video filename.
     * @param array  $uploadParams  An array created by Request\Internal::requestVideoUploadURL()!
     * @param int    $maxAttempts   Total attempts to upload all chunks before throwing.
     *
     * @throws \InvalidArgumentException
     * @throws \InstagramAPI\Exception\InstagramException
     * @throws \InstagramAPI\Exception\UploadFailedException If the upload fails.
     *
     * @return \InstagramAPI\Response\UploadVideoResponse
     */
    public function uploadVideoChunks(
        $targetFeed,
        $videoFilename,
        array $uploadParams,
        $maxAttempts = 10)
    {
        $this->_throwIfNotLoggedIn();

        // We require at least 1 attempt, otherwise we can't do anything.
        if ($maxAttempts < 1) {
            throw new \InvalidArgumentException('The maxAttempts parameter must be 1 or higher.');
        }

        // Verify that the file exists locally.
        if (!is_file($videoFilename)) {
            throw new \InvalidArgumentException(sprintf(
                'The video file "%s" does not exist on disk.',
                $videoFilename
            ));
        }

        // To support video uploads to albums, we MUST fake-inject the
        // "sessionid" cookie from "i.instagram" into our "upload.instagram"
        // request, otherwise the server will reply with a "StagedUpload not
        // found" error when the final chunk has been uploaded.
        $sessionIDCookie = null;
        if ($targetFeed == 'album') {
            $foundCookie = $this->getCookie('sessionid', 'i.instagram.com');
            if ($foundCookie !== null) {
                $sessionIDCookie = $foundCookie->getValue();
            }
            if ($sessionIDCookie === null) { // Verify value.
                throw new \InstagramAPI\Exception\UploadFailedException(
                    'Unable to find the necessary SessionID cookie for uploading video album chunks.'
                );
            }
        }

        // Determine correct file extension for the video format.
        $videoExt = pathinfo($videoFilename, PATHINFO_EXTENSION);
        if (strlen($videoExt) == 0) {
            $videoExt = 'mp4'; // Fallback.
        }

        // Video uploads should be chunked to save RAM; determine chunk size!
        $videoSize = filesize($videoFilename);
        if ($videoSize < 1) {
            throw new \InstagramAPI\Exception\UploadFailedException(sprintf(
                'Upload of "%s" failed. The file is empty.',
                $videoFilename
            ));
        }
        $numChunks = ceil($videoSize / 524288); // We want <= 512KB per chunk.
        $maxChunkSize = ceil($videoSize / $numChunks); // Calc actual chunksize.

        // Calculate the per-chunk parameters and byte ranges.
        $videoChunks = [];
        $remainingBytes = $videoSize; // Tracks remaining bytes in video file.
        $rangeStart = 0;
        for ($chunkIdx = 1; $chunkIdx <= $numChunks; ++$chunkIdx) {
            // Use "max chunk size" OR remaining bytes, whichever is smaller.
            $chunkSize = $chunkIdx >= $numChunks
                         ? $remainingBytes // Final chunk uses remaining bytes.
                         : min($remainingBytes, $maxChunkSize); // Smallest num.
            if ($chunkSize <= 0) {
                break; // Prevent empty chunks.
            }

            // Track how many bytes now remain in the file after this chunk.
            $remainingBytes -= $chunkSize;

            // Calculate where the current byte range will end.
            // NOTE: Range is 0-indexed, and Start is the first byte of the
            // new chunk we're uploading, hence we MUST subtract 1 from End.
            // And our FINAL chunk's End must be 1 less than the filesize!
            $rangeEnd = $rangeStart + ($chunkSize - 1);

            // Add the current chunk's parameters to the list.
            $videoChunks[] = [
                'fileOffset' => $rangeStart, // fseek offsets are 0-indexed too!
                'chunkSize'  => $chunkSize, // Size (in bytes) of this chunk.
                'rangeStart' => $rangeStart, // Start offset for the HTTP chunk.
                'rangeEnd'   => $rangeEnd, // End offset for the HTTP chunk.
            ];

            // Update the range's Start for the next iteration.
            // NOTE: It's the End-byte of the previous range, plus one.
            $rangeStart = $rangeEnd + 1;
        }

        // Read and upload each individual chunk, doing retries when necessary.
        $handle = fopen($videoFilename, 'r');
        $response = ['body' => '']; // Initialize with an empty server response.
        try {
            $uploadedRanges = [];
            for ($attempt = 1; $attempt <= $maxAttempts; ++$attempt) {
                // Upload all missing chunks to the server for this attempt.
                foreach ($videoChunks as $chunk) {
                    // Skip this chunk if the server already has it.
                    foreach ($uploadedRanges as $serverRange) {
                        if ($serverRange['start'] <= $chunk['rangeStart']
                            && $serverRange['end'] >= $chunk['rangeEnd']) {
                            continue 2; // Iterate to the next chunk.
                        }
                    }

                    // Seek to the exact file byte-offset of this chunk.
                    $result = fseek($handle, $chunk['fileOffset'], SEEK_SET);
                    if ($result !== 0) {
                        throw new \InstagramAPI\Exception\UploadFailedException(sprintf(
                            'Upload of "%s" failed. Unable to seek to the %d byte offset.',
                            $videoFilename, $chunk['fileOffset']
                        ));
                    }

                    // Attempt to read the exact bytes we need for this chunk.
                    $chunkData = fread($handle, $chunk['chunkSize']);
                    if (strlen($chunkData) != $chunk['chunkSize']) {
                        throw new \InstagramAPI\Exception\UploadFailedException(sprintf(
                            'Upload of "%s" failed. Unable to read %d bytes from file.',
                            $videoFilename, $chunk['chunkSize']
                        ));
                    }

                    // Build the current chunk's request options.
                    $method = 'POST';
                    $headers = [
                        'User-Agent'          => $this->_userAgent,
                        'Connection'          => 'keep-alive',
                        'Accept'              => '*/*',
                        'Cookie2'             => '$Version=1',
                        'Accept-Encoding'     => 'gzip, deflate',
                        'Content-Type'        => 'application/octet-stream',
                        'Session-ID'          => $uploadParams['uploadId'],
                        'Accept-Language'     => Constants::ACCEPT_LANGUAGE,
                        'Content-Disposition' => "attachment; filename=\"video.{$videoExt}\"",
                        'Content-Range'       => 'bytes '.$chunk['rangeStart'].'-'.$chunk['rangeEnd'].'/'.$videoSize,
                        'job'                 => $uploadParams['job'],
                    ];
                    $options = [
                        'headers' => $headers,
                        'body'    => $chunkData,
                    ];

                    // When uploading videos to albums, we must fake-inject the
                    // "sessionid" cookie (the official app fake-injects it too).
                    if ($targetFeed == 'album' && $sessionIDCookie !== null) {
                        // We'll add it with the default options ("single use")
                        // so the fake cookie is only added to THIS request.
                        $this->_clientMiddleware->addFakeCookie('sessionid', $sessionIDCookie);
                    }

                    // Perform the upload of the current chunk.
                    $response = $this->_apiRequest(
                        $method,
                        1, // API Version.
                        $uploadParams['uploadUrl'],
                        $options,
                        [
                            'debugUploadedBody'  => false,
                            'debugUploadedBytes' => true,
                            'decodeToObject'     => false,
                        ]
                    );

                    // Process the server response...
                    if (substr($response['body'], 0, 1) === '{') {
                        // All chunks are uploaded and the server has given us
                        // a JSON reply. Break out of our main upload-loop.
                        break 2;
                    } else {
                        // The server has given us a regular reply. We expect it
                        // to be a range-reply, such as "0-3912399/23929393".
                        // Their server often drops chunks during peak hours,
                        // and in that case the first range may not start at
                        // zero, or there may be gaps or multiple ranges, such
                        // as "0-4076155/8152310,6114234-8152309/8152310". We'll
                        // handle that by re-uploading whatever they've dropped.
                        preg_match_all('/(?<start>\d+)-(?<end>\d+)\/(?<total>\d+)/', $response['body'], $matches, PREG_SET_ORDER);
                        if (count($matches) == 0) {
                            // Fail if the response contains no byte ranges!
                            throw new \InstagramAPI\Exception\UploadFailedException(sprintf(
                                "Upload of \"%s\" failed. Instagram's server returned an unexpected reply (\"%s\").",
                                $videoFilename, $response['body']
                            ));
                        }

                        // Keep track of which range(s) the server has received,
                        // so that we will re-upload their missing ranges.
                        $uploadedRanges = [];
                        foreach ($matches as $match) {
                            $uploadedRanges[] = [
                                'start' => $match['start'],
                                'end'   => $match['end'],
                            ];
                        }
                    }
                }
            }
        } finally {
            // Guaranteed to release handle even if something bad happens above!
            fclose($handle);
        }

        // NOTE: $response below refers to the final chunk's result!

        // Protection against Instagram's upload server being bugged out!
        // NOTE: When their server is bugging out, the final chunk result will
        // still be yet another range specifier such as "328600-657199/657200",
        // instead of a "{...}" JSON object. Because their server will have
        // dropped some chunks when they bug out (due to overload or w/e).
        if (substr($response['body'], 0, 1) !== '{') {
            throw new \InstagramAPI\Exception\UploadFailedException(sprintf(
                "Upload of \"%s\" failed. Instagram's server returned an unexpected reply and is probably overloaded.",
                $videoFilename
            ));
        }

        // Manually decode the final API response and check for successful chunked upload.
        $upload = $this->getMappedResponseObject(
            new Response\UploadVideoResponse(),
            self::api_body_decode($response['body']) // Important: Special JSON decoder.
        );

        return $upload;
    }

    /**
     * Decode a JSON reply from Instagram's API.
     *
     * WARNING: EXTREMELY IMPORTANT! NEVER, *EVER* USE THE BASIC "json_decode"
     * ON API REPLIES! ALWAYS USE THIS METHOD INSTEAD, TO ENSURE PROPER DECODING
     * OF BIG NUMBERS! OTHERWISE YOU'LL TRUNCATE VARIOUS INSTAGRAM API FIELDS!
     *
     * @param string $json  The body (JSON string) of the API response.
     * @param bool   $assoc When TRUE, decode to associative array instead of object.
     *
     * @return object|array|null Object if assoc false, Array if assoc true,
     *                           or NULL if unable to decode JSON.
     */
    public static function api_body_decode(
        $json,
        $assoc = false)
    {
        return json_decode($json, $assoc, 512, JSON_BIGINT_AS_STRING);
    }
}
