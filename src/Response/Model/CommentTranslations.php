<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method string getId()
 * @method mixed getTranslation()
 * @method bool isId()
 * @method bool isTranslation()
 * @method setId(string $value)
 * @method setTranslation(mixed $value)
 */
class CommentTranslations extends AutoPropertyHandler
{
    /**
     * @var string
     */
    public $id;
    public $translation;
}
