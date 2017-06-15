<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method Model\CommentTranslations[] getCommentTranslations()
 * @method bool isCommentTranslations()
 * @method setCommentTranslations(Model\CommentTranslations[] $value)
 */
class TranslateResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    /**
     * @var Model\CommentTranslations[]
     */
    public $comment_translations;
}
