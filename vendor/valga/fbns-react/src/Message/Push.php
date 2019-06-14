<?php

namespace Fbns\Client\Message;

use Fbns\Client\Json;

class Push
{
    /**
     * @var string
     */
    private $json;

    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $connectionKey;

    /**
     * @var string
     */
    private $packageName;

    /**
     * @var string
     */
    private $collapseKey;

    /**
     * @var string
     */
    private $payload;

    /**
     * @var string
     */
    private $notificationId;

    /**
     * @var string
     */
    private $isBuffered;

    /**
     * @param string $json
     */
    private function parseJson($json)
    {
        $data = Json::decode($json);
        $this->json = $json;

        if (isset($data->token)) {
            $this->token = (string) $data->token;
        }
        if (isset($data->ck)) {
            $this->connectionKey = (string) $data->ck;
        }
        if (isset($data->pn)) {
            $this->packageName = (string) $data->pn;
        }
        if (isset($data->cp)) {
            $this->collapseKey = (string) $data->cp;
        }
        if (isset($data->fbpushnotif)) {
            $this->payload = (string) $data->fbpushnotif;
        }
        if (isset($data->nid)) {
            $this->notificationId = (string) $data->nid;
        }
        if (isset($data->bu)) {
            $this->isBuffered = (string) $data->bu;
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
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function getConnectionKey()
    {
        return $this->connectionKey;
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
    public function getCollapseKey()
    {
        return $this->collapseKey;
    }

    /**
     * @return string
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @return string
     */
    public function getNotificationId()
    {
        return $this->notificationId;
    }

    /**
     * @return string
     */
    public function getIsBuffered()
    {
        return $this->isBuffered;
    }
}
