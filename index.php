<?php
// **author**
// naer (http://github.com/naer2/)
require("config.php");

$verification_method = 1; 	//0 = SMS, 1 = Email
class ExtendedInstagram extends \InstagramAPI\Instagram {
	public function changeUser($username2, $password2) {$this->_setUser( $username2, $password2 );}
}
function readln( $prompt ) {
	if ( PHP_OS === 'WINNT' ) {echo "$prompt ";return trim( (string) stream_get_line( STDIN, 6, "\n" ) );}
	return trim( (string) readline( "$prompt " ) );
}

$ig = new ExtendedInstagram(false, $truncatedDebug);

function createFolder($folder){
	if ((is_dir($folder) && is_writable($folder)) || (!is_dir($folder) && mkdir($folder, 0755, true))|| chmod($folder, 0755))return true;
	return false;
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
			echo 'Exception '.$storiesUserName.PHP_EOL;
			$response1 = $e->getResponse();
			$errorStr = $storiesUserName.' not found';
			file_put_contents("errors.txt",$errorStr,FILE_APPEND);
			file_put_contents("errors.txt",$response1,FILE_APPEND);
			file_put_contents("errors.txt",$e,FILE_APPEND);
			file_put_contents("errors.txt",var_dump($e),FILE_APPEND);
			file_put_contents("errors.txt",print_r($e),FILE_APPEND);
			continue;
		}
		$storyFeed = $ig->story->getUserStoryFeed($userID);
		// echo $storyUserName.PHP_EOL;var_dump($storyFeed);
		$storyReel = $storyFeed->getReel();
		if(!$storyReel){
			// echo 'Here is nothing in '.$storiesUserName.' stories'.PHP_EOL;
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
		sleep(2);
	}
} catch (\Exception $exception) {
	$response = $exception->getResponse();
	$fatalError = "Fatal error ".PHP_EOL;
	file_put_contents("fatals.txt",$fatalError,FILE_APPEND);
	file_put_contents("fatals.txt",$exception,FILE_APPEND);
	file_put_contents("fatals.txt",$response,FILE_APPEND);
	file_put_contents("fatals.txt",$var_dump($exception),FILE_APPEND);
	file_put_contents("fatals.txt",$print_r($exception),FILE_APPEND);
	if ($response->getErrorType() === 'checkpoint_challenge_required') {
		sleep(3);
		$checkApiPath = substr( $response->getChallenge()->getApiPath(), 1);
		$customResponse = $ig->request($checkApiPath)->setNeedsAuth(false)->addPost('choice', $verification_method)->addPost('_uuid', $ig->uuid)
		->addPost('guid', $ig->uuid)->addPost('device_id', $ig->device_id)->addPost('_uid', $ig->account_id)->addPost('_csrftoken', $ig->client->getToken())->getDecodedResponse();
	}
	else {
		exit;
	}
	try {
		if ($customResponse['status'] === 'ok' && $customResponse['action'] === 'close') {
			exit();
		}
		$code = readln( 'Code that you received via ' . ( $verification_method ? 'email' : 'sms' ) . ':' );
		$ig->changeUser($username, $password);
		$customResponse = $ig->request($checkApiPath)->setNeedsAuth(false)->addPost('security_code', $code)->addPost('_uuid', $ig->uuid)->addPost('guid', $ig->uuid)->addPost('device_id', $ig->device_id)->addPost('_uid', $ig->account_id)->addPost('_csrftoken', $ig->client->getToken())->getDecodedResponse();
		if ($customResponse['status'] === 'ok' && (int) $customResponse['logged_in_user']['pk'] === (int) $user_id ) {
		} else {
			var_dump( $customResponse );
		}
	}
	catch ( Exception $ex ) {
		echo $ex->getMessage();
	}
}