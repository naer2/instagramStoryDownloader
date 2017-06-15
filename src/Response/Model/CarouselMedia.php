<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method string getCarouselParentId()
 * @method mixed getHasAudio()
 * @method string getId()
 * @method Image_Versions2 getImageVersions2()
 * @method mixed getMediaType()
 * @method mixed getOriginalHeight()
 * @method mixed getOriginalWidth()
 * @method string getPk()
 * @method mixed getPreview()
 * @method Usertag getUsertags()
 * @method mixed getVideoDuration()
 * @method VideoVersions[] getVideoVersions()
 * @method bool isCarouselParentId()
 * @method bool isHasAudio()
 * @method bool isId()
 * @method bool isImageVersions2()
 * @method bool isMediaType()
 * @method bool isOriginalHeight()
 * @method bool isOriginalWidth()
 * @method bool isPk()
 * @method bool isPreview()
 * @method bool isUsertags()
 * @method bool isVideoDuration()
 * @method bool isVideoVersions()
 * @method setCarouselParentId(string $value)
 * @method setHasAudio(mixed $value)
 * @method setId(string $value)
 * @method setImageVersions2(Image_Versions2 $value)
 * @method setMediaType(mixed $value)
 * @method setOriginalHeight(mixed $value)
 * @method setOriginalWidth(mixed $value)
 * @method setPk(string $value)
 * @method setPreview(mixed $value)
 * @method setUsertags(Usertag $value)
 * @method setVideoDuration(mixed $value)
 * @method setVideoVersions(VideoVersions[] $value)
 */
class CarouselMedia extends AutoPropertyHandler
{
    const PHOTO = 1;
    const VIDEO = 2;

    /**
     * @var string
     */
    public $pk;
    /**
     * @var string
     */
    public $id;
    /**
     * @var string
     */
    public $carousel_parent_id;
    /**
     * @var Image_Versions2
     */
    public $image_versions2;
    /**
     * @var VideoVersions[]
     */
    public $video_versions;
    public $has_audio;
    public $video_duration;
    public $original_height;
    public $original_width;
    public $media_type;
    /**
     * @var Usertag
     */
    public $usertags;
    public $preview;
}
