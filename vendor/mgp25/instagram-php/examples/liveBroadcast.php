<?php

set_time_limit(0);
date_default_timezone_set('UTC');

require __DIR__.'/../vendor/autoload.php';

/////// CONFIG ///////
$username = '';
$password = '';
$debug = true;
$truncatedDebug = false;
//////////////////////

/////// MEDIA ////////
$videoFilename = '';
//////////////////////

$ig = new \InstagramAPI\Instagram($debug, $truncatedDebug);

try {
    $ig->login($username, $password);
} catch (\Exception $e) {
    echo 'Something went wrong: '.$e->getMessage()."\n";
    exit(0);
}

try {
    // NOTE: This code will create a broadcast, which will give us an RTMP url
    // where we are supposed to stream-upload the media we want to broadcast.
    //
    // The following code is using FFMPEG to broadcast, although other
    // alternatives are valid too, like OBS (Open Broadcaster Software,
    // https://obsproject.com).
    //
    // For more information on FFMPEG, see:
    // https://github.com/mgp25/Instagram-API/issues/1488#issuecomment-324271177
    // and for OBS, see:
    // https://github.com/mgp25/Instagram-API/issues/1488#issuecomment-333365636

    // Get FFmpeg handler and ensure that the application exists on this system.
    // NOTE: Look in `\InstagramAPI\Utils` if you want a custom ffmpeg path.
    $ffmpeg = \InstagramAPI\Utils::getFFmpegWrapper();

    // Tell Instagram that we want to perform a livestream.
    $stream = $ig->live->create();
    $ig->live->start($stream->getBroadcastId());

    // Switch from RTMPS to RTMP upload URL, since RTMPS doesn't work well.
    $streamUploadUrl = preg_replace(
        '#^rtmps://([^/]+?):443/#ui',
        'rtmp://\1:80/',
        $stream->getUploadUrl()
    );

    // Broadcast the entire video file.
    $ffmpeg->run(sprintf(
        '-rtbufsize 256M -re -i %s -acodec libmp3lame -ar 44100 -b:a 128k -pix_fmt yuv420p -profile:v baseline -s 720x1280 -bufsize 6000k -vb 400k -maxrate 1500k -deinterlace -vcodec libx264 -preset veryfast -g 30 -r 30 -f flv %s',
        escapeshellarg($videoFilename),
        escapeshellarg($streamUploadUrl)
    ));

    // End the broadcast stream.
    // NOTE: Instagram will ALSO end the stream if your broadcasting software
    // itself sends a RTMP signal to end the stream. FFmpeg doesn't do that
    // (without patching), but OBS sends such a packet. So be aware of that.
    $ig->live->end($stream->getBroadcastId());

    // Once the broadcast has ended, you can optionally add the finished
    // broadcast to your post-live feed (saved replay).
    $ig->live->addToPostLive($stream->getBroadcastId());
} catch (\Exception $e) {
    echo 'Something went wrong: '.$e->getMessage()."\n";
}
