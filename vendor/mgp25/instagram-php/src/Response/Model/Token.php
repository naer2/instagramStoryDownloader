<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyMapper;

/**
 * Token.
 *
 * @method int getCarrierId()
 * @method string getCarrierName()
 * @method mixed getEnabledWalletDefsKeys()
 * @method mixed getFeatures()
 * @method string getRequestTime()
 * @method mixed getRewriteRules()
 * @method string getTokenHash()
 * @method int getTtl()
 * @method bool isCarrierId()
 * @method bool isCarrierName()
 * @method bool isEnabledWalletDefsKeys()
 * @method bool isFeatures()
 * @method bool isRequestTime()
 * @method bool isRewriteRules()
 * @method bool isTokenHash()
 * @method bool isTtl()
 * @method $this setCarrierId(int $value)
 * @method $this setCarrierName(string $value)
 * @method $this setEnabledWalletDefsKeys(mixed $value)
 * @method $this setFeatures(mixed $value)
 * @method $this setRequestTime(string $value)
 * @method $this setRewriteRules(mixed $value)
 * @method $this setTokenHash(string $value)
 * @method $this setTtl(int $value)
 * @method $this unsetCarrierId()
 * @method $this unsetCarrierName()
 * @method $this unsetEnabledWalletDefsKeys()
 * @method $this unsetFeatures()
 * @method $this unsetRequestTime()
 * @method $this unsetRewriteRules()
 * @method $this unsetTokenHash()
 * @method $this unsetTtl()
 */
class Token extends AutoPropertyMapper
{
    const JSON_PROPERTY_MAP = [
        'carrier_name'             => 'string',
        'carrier_id'               => 'int',
        'ttl'                      => 'int',
        'features'                 => '',
        'request_time'             => 'string',
        'token_hash'               => 'string',
        'rewrite_rules'            => '',
        'enabled_wallet_defs_keys' => '',
    ];
}
