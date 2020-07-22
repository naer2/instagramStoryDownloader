<?php

	// **author**
	// naer (http://github.com/naer2/)

	require("config.php");

	$login_attempt_log_file = "login_attempt.txt";
	$general_error_log_file = "fatals.txt";
	$loop_error_log_file = "errors.txt";

	$users_loop_delay = 3; // in seconds, php script system sleep time

	$verification_method = 1; 	//0 = SMS, 1 = Email

	class ExtendedInstagram extends \InstagramAPI\Instagram {
		public function changeUser($username2, $password2) {$this->_setUser( $username2, $password2 );}
	}

	function readln( $prompt ) {
		if ( PHP_OS === 'WINNT' ) {echo "$prompt ";return trim( (string) stream_get_line( STDIN, 6, "\n" ) );}
		return trim( (string) readline( "$prompt " ) );
	}

	$ig = new ExtendedInstagram(false, true);

	function createFolder($folder){
		if ((is_dir($folder) && is_writable($folder)) || (!is_dir($folder) && mkdir($folder, 0755, true))|| chmod($folder, 0755))return true;
		return false;
	}

	function log_it($filename, $str, $print = false, $show_line_number = -1){
		if($show_line_number !== -1) {
			$text = "Line: ".$show_line_number.PHP_EOL;
			file_put_contents($filename,date('Y m d H:i:s - ').print_r($text, true),FILE_APPEND);
		}
		file_put_contents($filename,date('Y m d H:i:s - ').print_r($str, true),FILE_APPEND);
		if($print) {
			echo $str;
		}
	}

	try {
		$array2 = file("users.ini", FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES);
		$ig->login($username, $password);
		$backupFolder = './downloaded/';
		if (!createFolder($backupFolder)) {
			echo "Can't create folder".$backupFolder;
		}
		foreach($array2 as $key => $storiesUserName){
			try{
				$userID = $ig->people->getUserIdForName($storiesUserName);
			}
			catch(\Exception $e){
				if($e instanceOf InstagramAPI\Exception\NotFoundException) {
					$text = 'User '.$storiesUserName.' not found skipping'.PHP_EOL;
					log_it($loop_error_log_file, $text, true, __LINE__-1);
					sleep($users_loop_delay);
					continue;
				}

				$text = 'Exception on '.$storiesUserName.PHP_EOL;
				log_it($loop_error_log_file, $text, true, __LINE__-1);

				$text = "e is ".print_r($e, true).".".PHP_EOL;
				log_it($loop_error_log_file, $text, true, __LINE__-1);

				$response1 = method_exists($e, 'getResponse') ? $e->getResponse() : null;
				$get_message = method_exists($e, 'getMessage') ? $e->getMessage() : null;
				$error_type = method_exists($response1, 'getErrorType') ? $response1->getErrorType() : null;

				$text = "Fatal error".PHP_EOL;
				log_it($loop_error_log_file, $text, true, __LINE__-1);

				$text = "getMessage is ".$get_message.".".PHP_EOL;
				log_it($loop_error_log_file, $text, true, __LINE__-1);

				$text = "getErrorType is ".$error_type.".".PHP_EOL;
				log_it($loop_error_log_file, $text, true, __LINE__-1);

				$text = "response1 is ".print_r($response1, true).".".PHP_EOL;
				log_it($loop_error_log_file, $text, true, __LINE__-1);

				sleep($users_loop_delay);
				continue;
			}
			$storyFeed = $ig->story->getUserStoryFeed($userID);
			// echo $storyUserName.PHP_EOL;var_dump($storyFeed);
			$storyReel = $storyFeed->getReel();
			if(!$storyReel){
				// echo 'Here is nothing in '.$storiesUserName.' stories'.PHP_EOL;
				sleep($users_loop_delay);
				continue;
			}
			$storyItems = $storyReel->getItems();
			$storyCount= count($storyItems);
			$mediaFiles = [];

			for ($i=0,$tempval; $i < $storyCount; $i++) {
				$item = $storyItems[$i];
				$itemDate = date('Y_m_d_H_i_s', $item->getTakenAt());
				if ($item->getMediaType() == 1)$mediaUrl = $item->getImageVersions2()->getCandidates()[0]->getUrl();
				else $mediaUrl = $item->getVideoVersions()[0]->getUrl();
				$itemId = sprintf('%s_%s_%s_',$storiesUserName, $itemDate, $item->getId());
				$mediaFiles[$itemId] = ['taken_at' => $item->getTakenAt(),'url' => $mediaUrl];
			}
			foreach ($mediaFiles as $mediaId => $mediaInfo) {
				$mediaUrl = $mediaInfo['url'];
				$filePath = $backupFolder.$mediaId.basename(parse_url($mediaUrl, PHP_URL_PATH));
				// echo sprintf("Downloading \"%s\" to \"%s\".\n\n", $mediaUrl,  $filePath);
				if(!is_file($filePath)){
					copy($mediaUrl, $filePath);
					if (is_file($filePath))touch($filePath, $mediaInfo['taken_at']);
				}
			}
			sleep($users_loop_delay);
		}
	}
	catch (\Exception $exception) {
		if($exception instanceOf InstagramAPI\Exception\ThrottledException) {
			$text = 'Too many api requests, $exception is '.print_r($exception, true).'.'.PHP_EOL;
			log_it($general_error_log_file, $text, true, __LINE__-1);
			return;
		}

		$text = "exception is ".print_r($exception, true).".".PHP_EOL;
		log_it($general_error_log_file, $text, true, __LINE__-1);

		$response = method_exists($exception, 'getResponse') ? $exception->getResponse() : null;
		$get_message = method_exists($exception, 'getMessage') ? $exception->getResponse() : null;
		$error_type = method_exists($response, 'getErrorType') ? $response->getErrorType() : null;

		$text = "Fatal error".PHP_EOL;
		log_it($general_error_log_file, $text, true, __LINE__-1);

		$text = "getMessage is ".$get_message.".".PHP_EOL;
		log_it($general_error_log_file, $text, true, __LINE__-1);

		$text = "getErrorType is ".$error_type.".".PHP_EOL;
		log_it($general_error_log_file, $text, true, __LINE__-1);

		$text = "response is ".print_r($response, true).".".PHP_EOL;
		log_it($general_error_log_file, $text, true, __LINE__-1);


		// If error_type is checkpoint_challenge_required then we need try to pass challenge
		if ($error_type === 'checkpoint_challenge_required') {
			sleep(3);
			// Getting api_path key from challenge array, removing first slash for future append
			$checkApiPath = substr($response->getChallenge()->getApiPath(), 1);
			// Trying to pass challenge
			$customResponse = $ig->request($checkApiPath)->
								setNeedsAuth(false)->
								addPost('choice', $verification_method)->
								addPost('_uuid', $ig->uuid)->
								addPost('guid', $ig->uuid)->
								addPost('device_id', $ig->device_id)->
								addPost('_uid', $ig->account_id)->
								addPost('_csrftoken', $ig->client->getToken())->
								getDecodedResponse();
			try {
				$text = "customResponse is ".print_r($customResponse, true).".".PHP_EOL;
				log_it($login_attempt_log_file, $text, true, __LINE__-1);

				if(isset($customResponse["status"]) && isset($customResponse["action"]) && $customResponse['status'] === 'ok' && $customResponse['action'] === 'close') {
					exit();
				}
				else if ($customResponse){
					$step_name = "";
					$freepass = false;

					/* var_dump($customResponse); */
					/* echo PHP_EOL.PHP_EOL.PHP_EOL.PHP_EOL; */

					if(isset($customResponse["step_name"]))$step_name = $customResponse["step_name"];
					else $freepass = true; // to not get inside loop just retry to send old code to api, ofc we can just check !$step_name
					if($freepass || $step_name == "verify_email" || $step_name == "verify_code") {
						echo 'Code that you received via '.($verification_method ? 'email' : 'sms');
						if(isset($customResponse["step_data"])) {
							if(isset($customResponse["step_data"]["contact_point"])) echo ' ('.$customResponse["step_data"]["contact_point"].')';
						}
						$code = readln(":\n");
						if(isset($code)) {
							$ig->changeUser($username, $password);
							$customResponse = $ig->request($checkApiPath)->
												setNeedsAuth(false)->
												addPost('security_code', $code)->
												addPost('_uuid', $ig->uuid)->
												addPost('guid', $ig->uuid)->
												addPost('device_id', $ig->device_id)->
												addPost('_uid', $ig->account_id)->
												addPost('_csrftoken', $ig->client->getToken())->
												getDecodedResponse();

							$text = "customResponse is ".print_r($customResponse, true).".".PHP_EOL;
							log_it($login_attempt_log_file, $text, true, __LINE__-1);

							if($customResponse && isset($customResponse["action"])&& isset($customResponse["status"])) {
								if($customResponse["action"] == "close" && $customResponse["status"] == "ok") {
									if(isset($customResponse["logged_in_user"])) {
										$text = "Loggined as ".$customResponse["logged_in_user"]["username"].", expected login: ".$username.".".PHP_EOL;
										log_it($login_attempt_log_file, $text, true, __LINE__-1);
										$text = "Everything is fine, visit instagram.com from browser and accept challenge (Press \"it was me\").".PHP_EOL;
										log_it($login_attempt_log_file, $text, true, __LINE__-1);
									}
									else {
										$text = "Something went wrong".PHP_EOL;
										log_it($login_attempt_log_file, $text, true, __LINE__-1);
										$text = "Response is".print_r($customResponse, true).PHP_EOL;
										log_it($login_attempt_log_file, $text, true, __LINE__-1);
									}
								}
							}
							else {
								$text = "Something went wrong".PHP_EOL;
								log_it($login_attempt_log_file, $text, true, __LINE__-1);
								$text = "Response is".print_r($customResponse, true).PHP_EOL;
								log_it($login_attempt_log_file, $text, true, __LINE__-1);
							}
						}
						else {
							echo "Try again.".PHP_EOL;
						}
					}
				}
				else {
					$text = "Something went wrong".PHP_EOL;
					log_it($login_attempt_log_file, $text, true, __LINE__-1);

					$text = "Response is".print_r($customResponse, true).PHP_EOL;
					log_it($login_attempt_log_file, $text, true, __LINE__-1);
				}
			}
			catch ( Exception $ex ) {
				$text = "exception is ".print_r($ex, true).".".PHP_EOL;
				log_it($general_error_log_file, $text, true, __LINE__-1);

				$response = method_exists($ex, 'getResponse') ? $ex->getResponse() : null;
				$get_message = method_exists($ex, 'getMessage') ? $ex->getMessage() : null;
				$error_type = method_exists($response, 'getErrorType') ? $response->getErrorType() : null;

				$text = "Fatal error".PHP_EOL;
				log_it($general_error_log_file, $text, true, __LINE__-1);

				$text = "getMessage is ".$get_message.".".PHP_EOL;
				log_it($general_error_log_file, $text, true, __LINE__-1);

				$text = "getErrorType is ".$error_type.".".PHP_EOL;
				log_it($general_error_log_file, $text, true, __LINE__-1);

				$text = "response is ".print_r($response, true).".".PHP_EOL;
				log_it($general_error_log_file, $text, true, __LINE__-1);
			}
		}
		else {
			exit;
		}
	}