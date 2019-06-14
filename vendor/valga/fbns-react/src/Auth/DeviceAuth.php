<?php

namespace Fbns\Client\Auth;

use Fbns\Client\AuthInterface;
use Fbns\Client\Json;

class DeviceAuth implements AuthInterface
{
    const TYPE = 'device_auth';

    /**
     * @var string
     */
    private $json;

    /**
     * @var int
     */
    private $clientId;

    /**
     * @var int
     */
    private $userId;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $deviceId;

    /**
     * @var string
     */
    private $deviceSecret;

    /**
     * @return string
     */
    private function randomUuid()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->clientId = substr($this->randomUuid(), 0, 20);
        $this->userId = 0;
        $this->password = '';
        $this->deviceSecret = '';
        $this->deviceId = '';
    }

    /**
     * @param string $json
     */
    public function read($json)
    {
        $data = Json::decode($json);
        $this->json = $json;

        if (isset($data->ck)) {
            $this->userId = $data->ck;
        } else {
            $this->userId = 0;
        }
        if (isset($data->cs)) {
            $this->password = $data->cs;
        } else {
            $this->password = '';
        }
        if (isset($data->di)) {
            $this->deviceId = $data->di;
            $this->clientId = substr($this->deviceId, 0, 20);
        } else {
            $this->deviceId = '';
            $this->clientId = substr($this->randomUuid(), 0, 20);
        }
        if (isset($data->ds)) {
            $this->deviceSecret = $data->ds;
        } else {
            $this->deviceSecret = '';
        }

        // TODO: sr ?
        // TODO: rc ?
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->json !== null ? $this->json : '';
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getDeviceId()
    {
        return $this->deviceId;
    }

    /**
     * @return string
     */
    public function getDeviceSecret()
    {
        return $this->deviceSecret;
    }

    /**
     * @return string
     */
    public function getClientType()
    {
        return self::TYPE;
    }

    /**
     * @return string
     */
    public function getClientId()
    {
        return $this->clientId;
    }
}
