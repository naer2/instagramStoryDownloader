<?php

namespace InstagramAPI\Devices;

/**
 * Android device User-Agent builder.
 *
 * @author SteveJobzniak (https://github.com/SteveJobzniak)
 */
class UserAgent
{
    /**
     * How to format the user agent string.
     *
     * @var string
     */
    const USER_AGENT_FORMAT = 'Instagram %s Android (%s/%s; %s; %s; %s; %s; %s; %s; %s)';

    /**
     * Generates a User Agent string from a Device.
     *
     * @param string $appVersion Instagram client app version.
     * @param string $userLocale The user's locale, such as "en_US".
     * @param Device $device
     *
     * @throws \InvalidArgumentException If the device parameter is invalid.
     *
     * @return string
     */
    public static function buildUserAgent(
        $appVersion,
        $userLocale,
        Device $device)
    {
        if (!$device instanceof Device) {
            throw new \InvalidArgumentException('The device parameter must be a Device class instance.');
        }

        // Build the appropriate "Manufacturer" or "Manufacturer/Brand" string.
        $manufacturerWithBrand = $device->getManufacturer();
        if ($device->getBrand() !== null) {
            $manufacturerWithBrand .= '/'.$device->getBrand();
        }

        // Generate the final User-Agent string.
        return sprintf(
            self::USER_AGENT_FORMAT,
            $appVersion, // App version ("10.8.0").
            $device->getAndroidVersion(),
            $device->getAndroidRelease(),
            $device->getDPI(),
            $device->getResolution(),
            $manufacturerWithBrand,
            $device->getModel(),
            $device->getDevice(),
            $device->getCPU(),
            $userLocale // Locale ("en_US").
        );
    }
}
