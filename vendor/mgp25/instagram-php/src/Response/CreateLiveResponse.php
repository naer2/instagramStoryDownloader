<?php

namespace InstagramAPI\Response;

use InstagramAPI\Response;

/**
 * CreateLiveResponse.
 *
 * @method mixed getAllowResolutionChange()
 * @method mixed getAvcRtmpPayload()
 * @method string getBroadcastId()
 * @method mixed getBroadcasterUpdateFrequency()
 * @method mixed getConnectWith_1rtt()
 * @method mixed getDisableSpeedTest()
 * @method mixed getHeartbeatInterval()
 * @method mixed getMaxTimeInSeconds()
 * @method mixed getMessage()
 * @method mixed getSpeedTestMinimumBandwidthThreshold()
 * @method mixed getSpeedTestRetryMaxCount()
 * @method mixed getSpeedTestRetryTimeDelay()
 * @method mixed getSpeedTestUiTimeout()
 * @method string getStatus()
 * @method mixed getStreamAudioBitRate()
 * @method mixed getStreamAudioChannels()
 * @method mixed getStreamAudioSampleRate()
 * @method mixed getStreamNetworkConnectionRetryCount()
 * @method mixed getStreamNetworkConnectionRetryDelayInSeconds()
 * @method mixed getStreamNetworkSpeedTestPayloadChunkSizeInBytes()
 * @method mixed getStreamNetworkSpeedTestPayloadSizeInBytes()
 * @method mixed getStreamNetworkSpeedTestPayloadTimeoutInSeconds()
 * @method mixed getStreamVideoAdaptiveBitrateConfig()
 * @method mixed getStreamVideoAllowBFrames()
 * @method mixed getStreamVideoBitRate()
 * @method mixed getStreamVideoFps()
 * @method mixed getStreamVideoWidth()
 * @method string getUploadUrl()
 * @method Model\_Message[] get_Messages()
 * @method bool isAllowResolutionChange()
 * @method bool isAvcRtmpPayload()
 * @method bool isBroadcastId()
 * @method bool isBroadcasterUpdateFrequency()
 * @method bool isConnectWith_1rtt()
 * @method bool isDisableSpeedTest()
 * @method bool isHeartbeatInterval()
 * @method bool isMaxTimeInSeconds()
 * @method bool isMessage()
 * @method bool isSpeedTestMinimumBandwidthThreshold()
 * @method bool isSpeedTestRetryMaxCount()
 * @method bool isSpeedTestRetryTimeDelay()
 * @method bool isSpeedTestUiTimeout()
 * @method bool isStatus()
 * @method bool isStreamAudioBitRate()
 * @method bool isStreamAudioChannels()
 * @method bool isStreamAudioSampleRate()
 * @method bool isStreamNetworkConnectionRetryCount()
 * @method bool isStreamNetworkConnectionRetryDelayInSeconds()
 * @method bool isStreamNetworkSpeedTestPayloadChunkSizeInBytes()
 * @method bool isStreamNetworkSpeedTestPayloadSizeInBytes()
 * @method bool isStreamNetworkSpeedTestPayloadTimeoutInSeconds()
 * @method bool isStreamVideoAdaptiveBitrateConfig()
 * @method bool isStreamVideoAllowBFrames()
 * @method bool isStreamVideoBitRate()
 * @method bool isStreamVideoFps()
 * @method bool isStreamVideoWidth()
 * @method bool isUploadUrl()
 * @method bool is_Messages()
 * @method $this setAllowResolutionChange(mixed $value)
 * @method $this setAvcRtmpPayload(mixed $value)
 * @method $this setBroadcastId(string $value)
 * @method $this setBroadcasterUpdateFrequency(mixed $value)
 * @method $this setConnectWith_1rtt(mixed $value)
 * @method $this setDisableSpeedTest(mixed $value)
 * @method $this setHeartbeatInterval(mixed $value)
 * @method $this setMaxTimeInSeconds(mixed $value)
 * @method $this setMessage(mixed $value)
 * @method $this setSpeedTestMinimumBandwidthThreshold(mixed $value)
 * @method $this setSpeedTestRetryMaxCount(mixed $value)
 * @method $this setSpeedTestRetryTimeDelay(mixed $value)
 * @method $this setSpeedTestUiTimeout(mixed $value)
 * @method $this setStatus(string $value)
 * @method $this setStreamAudioBitRate(mixed $value)
 * @method $this setStreamAudioChannels(mixed $value)
 * @method $this setStreamAudioSampleRate(mixed $value)
 * @method $this setStreamNetworkConnectionRetryCount(mixed $value)
 * @method $this setStreamNetworkConnectionRetryDelayInSeconds(mixed $value)
 * @method $this setStreamNetworkSpeedTestPayloadChunkSizeInBytes(mixed $value)
 * @method $this setStreamNetworkSpeedTestPayloadSizeInBytes(mixed $value)
 * @method $this setStreamNetworkSpeedTestPayloadTimeoutInSeconds(mixed $value)
 * @method $this setStreamVideoAdaptiveBitrateConfig(mixed $value)
 * @method $this setStreamVideoAllowBFrames(mixed $value)
 * @method $this setStreamVideoBitRate(mixed $value)
 * @method $this setStreamVideoFps(mixed $value)
 * @method $this setStreamVideoWidth(mixed $value)
 * @method $this setUploadUrl(string $value)
 * @method $this set_Messages(Model\_Message[] $value)
 * @method $this unsetAllowResolutionChange()
 * @method $this unsetAvcRtmpPayload()
 * @method $this unsetBroadcastId()
 * @method $this unsetBroadcasterUpdateFrequency()
 * @method $this unsetConnectWith_1rtt()
 * @method $this unsetDisableSpeedTest()
 * @method $this unsetHeartbeatInterval()
 * @method $this unsetMaxTimeInSeconds()
 * @method $this unsetMessage()
 * @method $this unsetSpeedTestMinimumBandwidthThreshold()
 * @method $this unsetSpeedTestRetryMaxCount()
 * @method $this unsetSpeedTestRetryTimeDelay()
 * @method $this unsetSpeedTestUiTimeout()
 * @method $this unsetStatus()
 * @method $this unsetStreamAudioBitRate()
 * @method $this unsetStreamAudioChannels()
 * @method $this unsetStreamAudioSampleRate()
 * @method $this unsetStreamNetworkConnectionRetryCount()
 * @method $this unsetStreamNetworkConnectionRetryDelayInSeconds()
 * @method $this unsetStreamNetworkSpeedTestPayloadChunkSizeInBytes()
 * @method $this unsetStreamNetworkSpeedTestPayloadSizeInBytes()
 * @method $this unsetStreamNetworkSpeedTestPayloadTimeoutInSeconds()
 * @method $this unsetStreamVideoAdaptiveBitrateConfig()
 * @method $this unsetStreamVideoAllowBFrames()
 * @method $this unsetStreamVideoBitRate()
 * @method $this unsetStreamVideoFps()
 * @method $this unsetStreamVideoWidth()
 * @method $this unsetUploadUrl()
 * @method $this unset_Messages()
 */
class CreateLiveResponse extends Response
{
    const JSON_PROPERTY_MAP = [
        'broadcast_id'                                          => 'string',
        'upload_url'                                            => 'string',
        'max_time_in_seconds'                                   => '',
        'speed_test_ui_timeout'                                 => '',
        'stream_network_speed_test_payload_chunk_size_in_bytes' => '',
        'stream_network_speed_test_payload_size_in_bytes'       => '',
        'stream_network_speed_test_payload_timeout_in_seconds'  => '',
        'speed_test_minimum_bandwidth_threshold'                => '',
        'speed_test_retry_max_count'                            => '',
        'speed_test_retry_time_delay'                           => '',
        'disable_speed_test'                                    => '',
        'stream_video_allow_b_frames'                           => '',
        'stream_video_width'                                    => '',
        'stream_video_bit_rate'                                 => '',
        'stream_video_fps'                                      => '',
        'stream_audio_bit_rate'                                 => '',
        'stream_audio_sample_rate'                              => '',
        'stream_audio_channels'                                 => '',
        'heartbeat_interval'                                    => '',
        'broadcaster_update_frequency'                          => '',
        'stream_video_adaptive_bitrate_config'                  => '',
        'stream_network_connection_retry_count'                 => '',
        'stream_network_connection_retry_delay_in_seconds'      => '',
        'connect_with_1rtt'                                     => '',
        'avc_rtmp_payload'                                      => '',
        'allow_resolution_change'                               => '',
    ];
}
