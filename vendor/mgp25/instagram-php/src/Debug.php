<?php

namespace InstagramAPI;

class Debug
{
    /*
     * If set to true, the debug logs will, in addition to being printed to console, be placed in the file noted below in $debugLogFile
     */
    public static $debugLog = false;
    /*
     * The file to place debug logs into when $debugLog is true
     */
    public static $debugLogFile = 'debug.log';

    public static function printRequest(
        $method,
        $endpoint)
    {
        if (PHP_SAPI === 'cli') {
            $cMethod = Utils::colouredString("{$method}:  ", 'light_blue');
        } else {
            $cMethod = $method.':  ';
        }
        echo $cMethod.$endpoint."\n";
        if (self::$debugLog) {
            file_put_contents(self::$debugLogFile, $method.':  '.$endpoint."\n", FILE_APPEND | LOCK_EX);
        }
    }

    public static function printUpload(
        $uploadBytes)
    {
        if (PHP_SAPI === 'cli') {
            $dat = Utils::colouredString('→ '.$uploadBytes, 'yellow');
        } else {
            $dat = '→ '.$uploadBytes;
        }
        echo $dat."\n";
        if (self::$debugLog) {
            file_put_contents(self::$debugLogFile, "→  $uploadBytes\n", FILE_APPEND | LOCK_EX);
        }
    }

    public static function printHttpCode(
        $httpCode,
        $bytes)
    {
        if (PHP_SAPI === 'cli') {
            echo Utils::colouredString("← {$httpCode} \t {$bytes}", 'green')."\n";
        } else {
            echo "← {$httpCode} \t {$bytes}\n";
        }
        if (self::$debugLog) {
            file_put_contents(self::$debugLogFile, "← {$httpCode} \t {$bytes}\n", FILE_APPEND | LOCK_EX);
        }
    }

    public static function printResponse(
        $response,
        $truncated = false)
    {
        if (PHP_SAPI === 'cli') {
            $res = Utils::colouredString('RESPONSE: ', 'cyan');
        } else {
            $res = 'RESPONSE: ';
        }
        if ($truncated && mb_strlen($response, 'utf8') > 1000) {
            $response = mb_substr($response, 0, 1000, 'utf8').'...';
        }
        echo $res.$response."\n\n";
        if (self::$debugLog) {
            file_put_contents(self::$debugLogFile, "RESPONSE: {$response}\n\n", FILE_APPEND | LOCK_EX);
        }
    }

    public static function printPostData(
        $post)
    {
        $gzip = mb_strpos($post, "\x1f"."\x8b"."\x08", 0, 'US-ASCII') === 0;
        if (PHP_SAPI === 'cli') {
            $dat = Utils::colouredString(($gzip ? 'DECODED ' : '').'DATA: ', 'yellow');
        } else {
            $dat = 'DATA: ';
        }
        echo $dat.urldecode(($gzip ? zlib_decode($post) : $post))."\n";
        if (self::$debugLog) {
            file_put_contents(self::$debugLogFile, 'DATA: '.urldecode(($gzip ? zlib_decode($post) : $post))."\n", FILE_APPEND | LOCK_EX);
        }
    }
}
