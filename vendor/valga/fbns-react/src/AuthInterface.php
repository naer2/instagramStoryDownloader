<?php

namespace Fbns\Client;

interface AuthInterface
{
    /**
     * @return string
     */
    public function getClientId();

    /**
     * @return string
     */
    public function getClientType();

    /**
     * @return int
     */
    public function getUserId();

    /**
     * @return string
     */
    public function getPassword();

    /**
     * @return string
     */
    public function getDeviceId();

    /**
     * @return string
     */
    public function getDeviceSecret();

    /**
     * @return string
     */
    public function __toString();
}
