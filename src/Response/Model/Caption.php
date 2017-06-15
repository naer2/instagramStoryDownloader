<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method mixed getBitFlags()
 * @method mixed getContentType()
 * @method mixed getCreatedAt()
 * @method mixed getCreatedAtUtc()
 * @method mixed getHasTranslation()
 * @method string getMediaId()
 * @method string getPk()
 * @method mixed getStatus()
 * @method mixed getText()
 * @method mixed getType()
 * @method User getUser()
 * @method string getUserId()
 * @method bool isBitFlags()
 * @method bool isContentType()
 * @method bool isCreatedAt()
 * @method bool isCreatedAtUtc()
 * @method bool isHasTranslation()
 * @method bool isMediaId()
 * @method bool isPk()
 * @method bool isStatus()
 * @method bool isText()
 * @method bool isType()
 * @method bool isUser()
 * @method bool isUserId()
 * @method setBitFlags(mixed $value)
 * @method setContentType(mixed $value)
 * @method setCreatedAt(mixed $value)
 * @method setCreatedAtUtc(mixed $value)
 * @method setHasTranslation(mixed $value)
 * @method setMediaId(string $value)
 * @method setPk(string $value)
 * @method setStatus(mixed $value)
 * @method setText(mixed $value)
 * @method setType(mixed $value)
 * @method setUser(User $value)
 * @method setUserId(string $value)
 */
class Caption extends AutoPropertyHandler
{
    public $status;
    /**
     * @var string
     */
    public $user_id;
    public $created_at_utc;
    public $created_at;
    public $bit_flags;
    /**
     * @var User
     */
    public $user;
    public $content_type;
    public $text;
    /**
     * @var string
     */
    public $media_id;
    /**
     * @var string
     */
    public $pk;
    public $type;
    public $has_translation;
}
