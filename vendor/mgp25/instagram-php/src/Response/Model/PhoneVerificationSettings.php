<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyMapper;

/**
 * PhoneVerificationSettings.
 *
 * @method mixed getMaxSmsCount()
 * @method mixed getResendSmsDelaySec()
 * @method mixed getRobocallAfterMaxSms()
 * @method mixed getRobocallCountDownTimeSec()
 * @method bool isMaxSmsCount()
 * @method bool isResendSmsDelaySec()
 * @method bool isRobocallAfterMaxSms()
 * @method bool isRobocallCountDownTimeSec()
 * @method $this setMaxSmsCount(mixed $value)
 * @method $this setResendSmsDelaySec(mixed $value)
 * @method $this setRobocallAfterMaxSms(mixed $value)
 * @method $this setRobocallCountDownTimeSec(mixed $value)
 * @method $this unsetMaxSmsCount()
 * @method $this unsetResendSmsDelaySec()
 * @method $this unsetRobocallAfterMaxSms()
 * @method $this unsetRobocallCountDownTimeSec()
 */
class PhoneVerificationSettings extends AutoPropertyMapper
{
    const JSON_PROPERTY_MAP = [
        'resend_sms_delay_sec'         => '',
        'max_sms_count'                => '',
        'robocall_count_down_time_sec' => '',
        'robocall_after_max_sms'       => '',
    ];
}
