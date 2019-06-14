<?php

namespace Fbns\Client\Message;

use Fbns\Client\Json;

class Register
{
    /**
     * @var string
     */
    private $json;

    /**
     * @var string
     */
    private $packageName;

    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $error;

    /**
     * @param string $json
     */
    private function parseJson($json)
    {
        $data = Json::decode($json);
        $this->json = $json;

        if (isset($data->pkg_name)) {
            $this->packageName = (string) $data->pkg_name;
        }
        if (isset($data->token)) {
            $this->token = (string) $data->token;
        }
        if (isset($data->error)) {
            $this->error = (string) $data->error;
        }
    }

    /**
     * Message constructor.
     *
     * @param string $json
     */
    public function __construct($json)
    {
        $this->parseJson($json);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->json;
    }

    /**
     * @return string
     */
    public function getPackageName()
    {
        return $this->packageName;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }
}
