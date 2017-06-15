<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method DirectLinkContext getLinkContext()
 * @method string getText()
 * @method bool isLinkContext()
 * @method bool isText()
 * @method setLinkContext(DirectLinkContext $value)
 * @method setText(string $value)
 */
class DirectLink extends AutoPropertyHandler
{
    /** @var string */
    public $text;
    /** @var DirectLinkContext */
    public $link_context;
}
