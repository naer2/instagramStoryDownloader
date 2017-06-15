<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method mixed getMaxSmsCount()
 * @method mixed getResendSmsDelaySec()
 * @method mixed getRobocallAfterMaxSms()
 * @method mixed getRobocallCountDownTimeSec()
 * @method bool isMaxSmsCount()
 * @method bool isResendSmsDelaySec()
 * @method bool isRobocallAfterMaxSms()
 * @method bool isRobocallCountDownTimeSec()
 * @method setMaxSmsCount(mixed $value)
 * @method setResendSmsDelaySec(mixed $value)
 * @method setRobocallAfterMaxSms(mixed $value)
 * @method setRobocallCountDownTimeSec(mixed $value)
 */
class PhoneVerificationSettings extends AutoPropertyHandler
{
    public $resend_sms_delay_sec;
    public $max_sms_count;
    public $robocall_count_down_time_sec;
    public $robocall_after_max_sms;
}
