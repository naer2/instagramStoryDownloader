<?php

namespace InstagramAPI;

/**
 * The interface that all response-classes must implement.
 *
 * Remember that all response-classes must "extend AutoPropertyHandler",
 * "implements ResponseInterface", and "use ResponseTrait", otherwise they
 * won't work properly.
 */
interface ResponseInterface
{
    /**
     * Sets the status.
     *
     * @param string|null $status
     */
    public function setStatus(
        $status);

    /**
     * Gets the status.
     *
     * @return string|null
     */
    public function getStatus();

    /**
     * Checks if a status value exists.
     *
     * @return bool
     */
    public function isStatus();

    /**
     * Sets the message.
     *
     * @param string|null $message
     */
    public function setMessage(
        $message);

    /**
     * Gets the message.
     *
     * @throws \Exception If the message object is of an unsupported type.
     *
     * @return string|null A message string if one exists, otherwise NULL.
     */
    public function getMessage();

    /**
     * Checks if a message value exists.
     *
     * @return bool
     */
    public function isMessage();

    /**
     * Sets the full response.
     *
     * @param mixed $response
     */
    public function setFullResponse(
        $response);

    /**
     * Gets the full response.
     *
     * @return mixed
     */
    public function getFullResponse();

    /**
     * Checks if a FullResponse value exists.
     *
     * @return bool
     */
    public function isFullResponse();

    /**
     * Checks if the response was successful.
     *
     * @return bool
     */
    public function isOk();
}
