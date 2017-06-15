<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method mixed getAddress()
 * @method mixed getCity()
 * @method string getExternalId()
 * @method string getExternalIdSource()
 * @method mixed getExternalSource()
 * @method string getFacebookEventsId()
 * @method string getFacebookPlacesId()
 * @method float getLat()
 * @method float getLng()
 * @method mixed getName()
 * @method string getPk()
 * @method mixed getShortName()
 * @method mixed getStartTime()
 * @method bool isAddress()
 * @method bool isCity()
 * @method bool isExternalId()
 * @method bool isExternalIdSource()
 * @method bool isExternalSource()
 * @method bool isFacebookEventsId()
 * @method bool isFacebookPlacesId()
 * @method bool isLat()
 * @method bool isLng()
 * @method bool isName()
 * @method bool isPk()
 * @method bool isShortName()
 * @method bool isStartTime()
 * @method setAddress(mixed $value)
 * @method setCity(mixed $value)
 * @method setExternalId(string $value)
 * @method setExternalIdSource(string $value)
 * @method setExternalSource(mixed $value)
 * @method setFacebookEventsId(string $value)
 * @method setFacebookPlacesId(string $value)
 * @method setLat(float $value)
 * @method setLng(float $value)
 * @method setName(mixed $value)
 * @method setPk(string $value)
 * @method setShortName(mixed $value)
 * @method setStartTime(mixed $value)
 */
class Location extends AutoPropertyHandler
{
    public $name;
    /**
     * @var string
     */
    public $external_id_source;
    public $external_source;
    public $address;
    /**
     * @var float
     */
    public $lat;
    /**
     * @var float
     */
    public $lng;
    /**
     * @var string
     */
    public $external_id;
    /**
     * @var string
     */
    public $facebook_places_id;
    public $city;
    /**
     * @var string
     */
    public $pk;
    public $short_name;
    /**
     * @var string
     */
    public $facebook_events_id;
    public $start_time;
}
