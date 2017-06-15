<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method mixed getKeywords()
 * @method bool isKeywords()
 * @method setKeywords(mixed $value)
 */
class CommentFilterKeywordsResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    public $keywords;
}
