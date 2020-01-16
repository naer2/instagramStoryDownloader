<?php

namespace InstagramAPI\Settings\Storage;

use InstagramAPI\Exception\SettingsException;
use InstagramAPI\Settings\StorageInterface;
use Redis as PHPRedis;

/**
 * Redis in-memory key-value storage backend.
 *
 * IMPORTANT!
 * You need https://github.com/phpredis/phpredis for this class:
 * $ pecl install redis
 *
 * @author Juan (https://github.com/Juan-de-Costa-Rica)
 */
class Redis implements StorageInterface
{
    /** @var PHPRedis Our connection to the Redis server. */
    private $_redis;
    /** @var bool Whether we own Redis' connection or are borrowing it. */
    private $_isSharedRedis;
    /** @var string Current Instagram username that all settings belong to. */
    private $_username;
    /** @var array Settings and cookies data: ['settings' => {DATA}, 'cookies' => {DATA}] */
    private $_cache;
    /** @var string The prefix to the username hash */
    private $_hashPrefix;

    /**
     * Connect to a storage location and perform necessary startup preparations.
     *
     * {@inheritdoc}
     */
    public function openLocation(
        array $locationConfig)
    {
        // Prefix to the hash, makes users searchable by the hash prefix
        $this->_hashPrefix = ((isset($locationConfig['redishash'])) ? $locationConfig['redishash'] : 'InstagramAPI:');

        if (isset($locationConfig['redis'])) {
            // Pre-provided connection to re-use instead of creating a new one.
            if (!$locationConfig['redis'] instanceof PHPRedis) {
                throw new SettingsException('The custom Redis object is invalid.');
            }
            $this->_isSharedRedis = true;
            $this->_redis = $locationConfig['redis'];

            // Check connection, throws if pre-provided connection no longer alive.
            $this->_checkConnection();
        } else {
            $this->_isSharedRedis = false;
            $this->_redis = new PHPRedis();

            // Use default connection if none provided.
            $address = ((isset($locationConfig['redishost'])) ? $locationConfig['redishost'] : '127.0.0.1');
            $port = ((isset($locationConfig['redisport'])) ? $locationConfig['redisport'] : '6379');

            // Connect.
            if (!$this->_redis->connect($address, $port)) {
                throw new SettingsException('Redis connection failed');
            }

            // Authenticate connection if provided.
            // Warning: The password is sent in plain-text over the network.
            if (isset($locationConfig['redisauth'])) {
                if (!$this->_redis->auth($locationConfig['redisauth'])) {
                    throw new SettingsException('Redis authentication failed');
                }
            }

            // Check connection, throws is authentication needed, but not provided.
            $this->_checkConnection();
        }
    }

    /**
     * Whether the storage backend contains a specific user.
     *
     * {@inheritdoc}
     */
    public function hasUser(
        $username)
    {
        $hash = $this->_gethash($username);

        return  $this->_redis->hExists($hash, 'settings');
    }

    /**
     * Move the internal data for a username to a new username.
     *
     * {@inheritdoc}
     */
    public function moveUser(
        $oldUsername,
        $newUsername)
    {
        // Get username hashes
        $oldHash = $this->_getHash($oldUsername);
        $newHash = $this->_getHash($newUsername);

        // Verify that the old username settings exists and get data
        $oldUserData = $this->_redis->hmGet($oldHash, ['settings', 'cookies']);
        if (empty($oldUserData['settings'])) {
            throw new SettingsException(sprintf(
                'Cannot move non-existent user "%s".',
                $oldUsername
            ));
        }

        // If no cookie, convert empty string to null
        $oldUserData['cookie'] = empty($oldUserData['cookie']) ? null : $oldUserData['cookie'];

        // Verify that the new username does not exist.
        if ($this->hasUser($newHash)) {
            throw new SettingsException(sprintf(
                'Refusing to overwrite existing user "%s".',
                $newUsername
            ));
        }

        // Write data to the new username hash & delete data from the old username hash
        $response = $this->_redis->multi()
            ->hmSet($newHash, $oldUserData)
            ->hDel($oldHash, 'settings', 'cookies')
            ->exec();

        // Throw Exceptions from response
        if ($response[0] === false) {
            throw new SettingsException('Redis failed to move user data');
        }
        if ($response[1] === 0) {
            throw new SettingsException('Redis failed to delete user data during move');
        }
    }

    /**
     * Delete all internal data for a given username.
     *
     * {@inheritdoc}
     */
    public function deleteUser(
        $username)
    {
        $hash = $this->_getHash($username);
        $response = $this->_redis->hDel($hash, 'settings', 'cookies');
        if ($response === 0) {
            throw new SettingsException('Redis failed to delete user data');
        }
    }

    /**
     * Open the data storage for a specific user.
     *
     * {@inheritdoc}
     */
    public function openUser(
        $username)
    {
        $hash = $this->_getHash($username);

        $this->_username = $username;

        $userData = $this->_redis->hmGet($hash, ['settings', 'cookies']);
        $this->_cache = [
            'settings' => empty($userData['settings']) ? null : $userData['settings'],
            'cookies'  => empty($userData['cookies']) ? null : $userData['cookies'],
        ];
    }

    /**
     * Load all settings for the currently active user.
     *
     * {@inheritdoc}
     */
    public function loadUserSettings()
    {
        $userSettings = [];
        if (!empty($this->_cache['settings'])) {
            $userSettings = @json_decode($this->_cache['settings'], true, 512, JSON_BIGINT_AS_STRING);
            if (!is_array($userSettings)) {
                throw new SettingsException(sprintf(
                    'Failed to decode corrupt settings for account "%s".',
                    $this->_username
                ));
            }
        }

        return $userSettings;
    }

    /**
     * Save the settings for the currently active user.
     *
     * {@inheritdoc}
     */
    public function saveUserSettings(
        array $userSettings,
        $triggerKey)
    {
        $hash = $this->_getHash($this->_username);

        // Store the settings as a JSON blob.
        $encodedData = json_encode($userSettings);
        $response = $this->_redis->hSet($hash, 'settings', $encodedData);

        if ($response === false) {
            throw new SettingsException('Redis failed to save user settings');
        }
    }

    /**
     * Whether the storage backend has cookies for the currently active user.
     *
     * {@inheritdoc}
     */
    public function hasUserCookies()
    {
        // Simply check if the storage key for cookies exists and is non-empty.
        return !empty($this->loadUserCookies()) ? true : false;
    }

    /**
     * Get the cookiefile disk path (only if a file-based cookie jar is wanted).
     *
     * {@inheritdoc}
     */
    public function getUserCookiesFilePath()
    {
        // NULL = We (the backend) will handle the cookie loading/saving.
        return null;
    }

    /**
     * (Non-cookiefile) Load all cookies for the currently active user.
     *
     * {@inheritdoc}
     */
    public function loadUserCookies()
    {
        return isset($this->_cache['cookies']) ? $this->_cache['cookies'] : null;
    }

    /**
     * (Non-cookiefile) Save all cookies for the currently active user.
     *
     * {@inheritdoc}
     */
    public function saveUserCookies(
        $rawData
    ) {
        $hash = $this->_getHash($this->_username);

        // Store the raw cookie data as-provided.
        $response = $this->_redis->hSet($hash, 'cookies', $rawData);

        if ($response === false) {
            throw new SettingsException('Redis failed to save user cookies');
        }
    }

    /**
     * Close the settings storage for the currently active user.
     *
     * {@inheritdoc}
     */
    public function closeUser()
    {
        $this->_username = null;
        $this->_cache = null;
    }

    /**
     * Disconnect from a storage location and perform necessary shutdown steps.
     *
     * {@inheritdoc}
     */
    public function closeLocation()
    {
        // Close all server connections if this was our own Redis object.
        if (!$this->_isSharedRedis) {
            if (!$this->_redis->close()) {
                throw new SettingsException('Redis disconnect failed');
            }
        }
        $this->_redis = null;
    }

    /**
     * Check the connection by pinging it.
     *
     * @throws \InstagramAPI\Exception\SettingsException
     */
    private function _checkConnection()
    {
        try {
            $this->_redis->ping();
        } catch (\Exception $e) {
            throw new SettingsException('Redis connection failed');
        }
    }

    /**
     * Gets hash value from username.
     *
     * @param string $username
     *
     * @return string
     */
    private function _getHash(
        $username)
    {
        return $this->_hashPrefix.$username;
    }
}
