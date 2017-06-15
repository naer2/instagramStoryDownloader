<?php

// **author**
// naer (http://github.com/naer2/)

require("config.php");

$ig = new \InstagramAPI\Instagram($debug, $truncatedDebug);

try {
    $ig->setUser($username, $password);
    $ig->login();
    $userID = $ig->getUsernameId($showStoryUsername);
    $storyFeed = $ig->getUserStoryFeed($userID);
    $storyCount= count($storyFeed->getReel()->getItems());

    for ($i=0; $i < $storyCount; $i++) {
      if ($storyFeed->getReel()->getItems()[$i]->getMediaType()==1) {
    echo "</br><img src='".$storyFeed->getReel()->getItems()[$i]->getImageVersions2()->getCandidates()[0]->getUrl()."' width='480' height='850'></br>";
      }
      else {
        echo "</br><video width='480' height='850' controls>
          <source src='".$storyFeed->getReel()->getItems()[$i]->getVideoVersions()[0]->getUrl()."' type='video/mp4'>
        Your browser does not support the video tag.
        </video></br>";
      }
    }

} catch (\Exception $e) {
    echo 'Something went wrong: '.$e->getMessage()."\n";
    exit(0);
}

?>
