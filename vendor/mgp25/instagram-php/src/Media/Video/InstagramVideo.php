<?php

namespace InstagramAPI\Media\Video;

use InstagramAPI\Media\Geometry\Dimensions;
use InstagramAPI\Media\Geometry\Rectangle;
use InstagramAPI\Media\InstagramMedia;
use InstagramAPI\Utils;

/**
 * Automatically prepares a video file according to Instagram's rules.
 *
 * @property VideoDetails $_details
 */
class InstagramVideo extends InstagramMedia
{
    /** @var FFmpegWrapper */
    protected $_ffmpegWrapper;

    /**
     * Constructor.
     *
     * @param string             $inputFile     Path to an input file.
     * @param array              $options       An associative array of optional parameters.
     * @param FFmpegWrapper|null $ffmpegWrapper Custom FFmpeg wrapper.
     *
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     *
     * @see InstagramMedia::__construct() description for the list of parameters.
     */
    public function __construct(
        $inputFile,
        array $options = [],
        FFmpegWrapper $ffmpegWrapper = null)
    {
        parent::__construct($inputFile, $options);
        $this->_details = new VideoDetails($inputFile);

        $this->_ffmpegWrapper = $ffmpegWrapper;
        if ($this->_ffmpegWrapper === null) {
            $this->_ffmpegWrapper = Utils::getFFmpegWrapper();
        }

        $this->_details = new VideoDetails($this->_inputFile);
    }

    /** {@inheritdoc} */
    protected function _isMod2CanvasRequired()
    {
        return true;
    }

    /** {@inheritdoc} */
    protected function _createOutputFile(
        Rectangle $srcRect,
        Rectangle $dstRect,
        Dimensions $canvas)
    {
        $outputFile = null;

        try {
            // Prepare output file.
            $outputFile = Utils::createTempFile($this->_tmpPath, 'VID');
            // Attempt to process the input file.
            // --------------------------------------------------------------
            // WARNING: This calls ffmpeg, which can run for a long time. The
            // user may be running in a CLI. In that case, if they press Ctrl-C
            // to abort, PHP won't run ANY of our shutdown/destructor handlers!
            // Therefore they'll still have the temp file if they abort ffmpeg
            // conversion with Ctrl-C, since our auto-cleanup won't run. There's
            // absolutely nothing good we can do about that (except a signal
            // handler to interrupt their Ctrl-C, which is a terrible idea).
            // Their OS should clear its temp folder periodically. Or if they
            // use a custom temp folder, it's THEIR own job to clear it!
            // --------------------------------------------------------------
            $this->_processVideo($srcRect, $dstRect, $canvas, $outputFile);
        } catch (\Exception $e) {
            if ($outputFile !== null && is_file($outputFile)) {
                @unlink($outputFile);
            }

            throw $e; // Re-throw.
        }

        return $outputFile;
    }

    /**
     * @param Rectangle  $srcRect    Rectangle to copy from the input.
     * @param Rectangle  $dstRect    Destination place and scale of copied pixels.
     * @param Dimensions $canvas     The size of the destination canvas.
     * @param string     $outputFile
     *
     * @throws \RuntimeException
     */
    protected function _processVideo(
        Rectangle $srcRect,
        Rectangle $dstRect,
        Dimensions $canvas,
        $outputFile)
    {
        // Swap to correct dimensions if the video pixels are stored rotated.
        if ($this->_details->hasSwappedAxes()) {
            $srcRect = $srcRect->withSwappedAxes();
            $dstRect = $dstRect->withSwappedAxes();
            $canvas = $canvas->withSwappedAxes();
        }

        // Prepare filters.
        $bgColor = sprintf('0x%02X%02X%02X', ...$this->_bgColor);
        $filters = [
            sprintf('crop=w=%d:h=%d:x=%d:y=%d', $srcRect->getWidth(), $srcRect->getHeight(), $srcRect->getX(), $srcRect->getY()),
            sprintf('scale=w=%d:h=%d', $dstRect->getWidth(), $dstRect->getHeight()),
            sprintf('pad=w=%d:h=%d:x=%d:y=%d:color=%s', $canvas->getWidth(), $canvas->getHeight(), $dstRect->getX(), $dstRect->getY(), $bgColor),
        ];

        $inputFormat = '';

        // Rotate the video (if needed to).
        $rotationFilters = $this->_getRotationFilters();
        if (count($rotationFilters)) {
            if ($this->_ffmpegWrapper->hasNoAutorotate()) {
                $inputFormat = '-noautorotate';
            }
            $filters = array_merge($filters, $rotationFilters);
        }

        // Video format can't copy since we always need to re-encode due to video filtering.
        $this->_ffmpegWrapper->run(sprintf(
            '%s -i %s -y -vf %s %s %s',
            $inputFormat,
            escapeshellarg($this->_inputFile),
            escapeshellarg(implode(',', $filters)),
            $this->_getOutputFormat(),
            escapeshellarg($outputFile)
        ));
    }

    /**
     * Get the output format.
     *
     * @return string
     */
    protected function _getOutputFormat()
    {
        $result = [
            '-metadata:s:v rotate=""', // Strip rotation from metadata.
            '-f mp4', // Force output format to MP4.
        ];

        // Force H.264 for the video.
        $result[] = '-c:v libx264 -preset fast -crf 24';

        // Force AAC for the audio.
        if ($this->_details->getAudioCodec() !== 'aac') {
            if ($this->_ffmpegWrapper->hasLibFdkAac()) {
                $result[] = '-c:a libfdk_aac -vbr 4';
            } else {
                // The encoder 'aac' is experimental but experimental codecs are not enabled,
                // add '-strict -2' if you want to use it.
                $result[] = '-strict -2 -c:a aac -b:a 96k';
            }
        } else {
            $result[] = '-c:a copy';
        }

        // Cut too long videos.
        if ($this->_details->getDuration() > $this->_constraints->getMaxDuration()) {
            $result[] = sprintf('-t %d', $this->_constraints->getMaxDuration());
        }

        // TODO Loop too short videos.
        if ($this->_details->getDuration() < $this->_constraints->getMinDuration()) {
            $times = ceil($this->_constraints->getMinDuration() / $this->_details->getDuration());
        }

        return implode(' ', $result);
    }

    /**
     * Get an array of filters needed to restore video orientation.
     *
     * @return array
     */
    protected function _getRotationFilters()
    {
        $result = [];
        if ($this->_details->hasSwappedAxes()) {
            if ($this->_details->isHorizontallyFlipped() && $this->_details->isVerticallyFlipped()) {
                $result[] = 'transpose=clock';
                $result[] = 'hflip';
            } elseif ($this->_details->isHorizontallyFlipped()) {
                $result[] = 'transpose=clock';
            } elseif ($this->_details->isVerticallyFlipped()) {
                $result[] = 'transpose=cclock';
            } else {
                $result[] = 'transpose=cclock';
                $result[] = 'vflip';
            }
        } else {
            if ($this->_details->isHorizontallyFlipped()) {
                $result[] = 'hflip';
            }
            if ($this->_details->isVerticallyFlipped()) {
                $result[] = 'vflip';
            }
        }

        return $result;
    }
}
