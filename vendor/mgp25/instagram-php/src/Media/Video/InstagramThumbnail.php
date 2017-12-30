<?php

namespace InstagramAPI\Media\Video;

/**
 * Automatically creates a video thumbnail according to Instagram's rules.
 */
class InstagramThumbnail extends InstagramVideo
{
    /** {@inheritdoc} */
    protected function _shouldProcess()
    {
        // We must always process the video to get its thumbnail.
        return true;
    }

    /** {@inheritdoc} */
    protected function _getOutputFormat()
    {
        // TODO Allow custom timestamp.
        return '-f mjpeg -ss 00:00:01 -vframes 1';
    }
}
