<?php

set_time_limit(0);
date_default_timezone_set('UTC');

require __DIR__.'/../vendor/autoload.php';

use InstagramAPI\Exception\ServerMessageThrower;

/*
 * Emulates various server responses and verifies that they're mapped
 * correctly by the ServerMessageThrower's parser.
 */
$exceptionsToTest = [
    'InstagramAPI\\Exception\\LoginRequiredException'      => '{"message":"login_required", "logout_reason": 2, "status": "fail"}',
    'InstagramAPI\\Exception\\FeedbackRequiredException'   => '{"message":"feedback_required","spam":true,"feedback_title":"You\u2019re Temporarily Blocked","feedback_message":"It looks like you were misusing this feature by going too fast. You\u2019ve been blocked from using it.\n\nLearn more about blocks in the Help Center. We restrict certain content and actions to protect our community. Tell us if you think we made a mistake.","feedback_url":"WUT","feedback_appeal_label":"Report problem","feedback_ignore_label":"OK","feedback_action":"report_problem","status":"fail"}',
    'InstagramAPI\\Exception\\CheckpointRequiredException' => '{"message":"checkpoint_required","checkpoint_url":"WUT","lock":true,"status":"fail","error_type":"checkpoint_challenge_required"}',
    'InstagramAPI\\Exception\\ChallengeRequiredException'  => '{"message":"challenge_required","challenge":{"url":"https://i.instagram.com/challenge/","api_path":"/challenge/","hide_webview_header":false,"lock":true,"logout":false,"native_flow":true},"status":"fail"}',
    'InstagramAPI\\Exception\\IncorrectPasswordException'  => '{"message":"The password you entered is incorrect. Please try again.","invalid_credentials":true,"error_title":"Incorrect password for WUT","buttons":[{"title":"Try Again","action":"dismiss"}],"status":"fail","error_type":"bad_password"}',
    'InstagramAPI\\Exception\\AccountDisabledException'    => '{"message":"Your account has been disabled for violating our terms. Learn how you may be able to restore your account."}',
    'InstagramAPI\\Exception\\InvalidUserException'        => '{"message":"The username you entered doesn\'t appear to belong to an account. Please check your username and try again.","invalid_credentials":true,"error_title":"Incorrect Username","buttons":[{"title":"Try Again","action":"dismiss"}],"status":"fail","error_type":"invalid_user"}',
    'InstagramAPI\\Exception\\SentryBlockException'        => '{"message":"Sorry, there was a problem with your request.","status":"fail","error_type":"sentry_block"}',
    'InstagramAPI\\Exception\\InvalidSmsCodeException'     => '{"message":"Please check the security code we sent you and try again.","status":"fail","error_type":"sms_code_validation_code_invalid"}',
];

foreach ($exceptionsToTest as $exceptionClassName => $testResponse) {
    $response = new \InstagramAPI\Response\GenericResponse(
        \InstagramAPI\Client::api_body_decode($testResponse)
    );

    try {
        ServerMessageThrower::autoThrow(null, $response->getMessage(), $response);
    } catch (\InstagramAPI\Exception\InstagramException $e) {
        $thisClassName = get_class($e);
        if ($exceptionClassName == $thisClassName) {
            echo "{$exceptionClassName}: OK!\n";
            // $e->getResponse()->printJson(); // Uncomment to look at the data.
        } else {
            echo "{$exceptionClassName}: Got {$thisClassName} instead!\n";
        }
    }
}
