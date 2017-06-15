<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method Image_Versions2 getImageVersions2()
 * @method mixed getMediaType()
 * @method mixed getOriginalHeight()
 * @method mixed getOriginalWidth()
 * @method VideoVersions[] getVideoVersions()
 * @method bool isImageVersions2()
 * @method bool isMediaType()
 * @method bool isOriginalHeight()
 * @method bool isOriginalWidth()
 * @method bool isVideoVersions()
 * @method setImageVersions2(Image_Versions2 $value)
 * @method setMediaType(mixed $value)
 * @method setOriginalHeight(mixed $value)
 * @method setOriginalWidth(mixed $value)
 * @method setVideoVersions(VideoVersions[] $value)
 */
class DirectThreadItemMedia extends AutoPropertyHandler
{
    const PHOTO = 1;
    const VIDEO = 2;

    public $media_type;
    /**
     * @var Image_Versions2
     */
    public $image_versions2;
    /**
     * @var VideoVersions[]
     */
    public $video_versions;
    public $original_width;
    public $original_height;
}
