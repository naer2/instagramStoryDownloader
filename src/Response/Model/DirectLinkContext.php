<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method string getLinkImageUrl()
 * @method string getLinkSummary()
 * @method string getLinkTitle()
 * @method string getLinkUrl()
 * @method bool isLinkImageUrl()
 * @method bool isLinkSummary()
 * @method bool isLinkTitle()
 * @method bool isLinkUrl()
 * @method setLinkImageUrl(string $value)
 * @method setLinkSummary(string $value)
 * @method setLinkTitle(string $value)
 * @method setLinkUrl(string $value)
 */
class DirectLinkContext extends AutoPropertyHandler
{
    /** @var string */
    public $link_url;
    /** @var string */
    public $link_title;
    /** @var string */
    public $link_summary;
    /** @var string */
    public $link_image_url;
}
