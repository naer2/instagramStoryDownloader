<?php
// **author**
// naer (http://github.com/naer2/)
require("config.php");
require("functions.php");

$ig = new \InstagramAPI\Instagram($debug, $truncatedDebug);
try {
    $ig->login($username, $password);
    $userID = $ig->people->getUserIdForName($showStoryUsername);
    $storyFeed = $ig->story->getUserStoryFeed($userID);
    $storyItems = $storyFeed->getReel()->getItems();
    $storyCount= count($storyItems);
    for ($i=0; $i < $storyCount; $i++) {
      //img
      echo time_elapsed_string("@".$storyItems[$i]->getTakenAt());
      if ($storyItems[$i]->getStoryCta()==null) {
         echo " ";
      }
      else {
          echo " & <a href='".$storyItems[$i]->getStoryCta()[0]->getLinks()[0]->getWebUri()."'>webUri</a>";
      }
      if ($storyItems[$i]->getMediaType()==1) {
        getImgHTML($storyItems[$i]->getImageVersions2()->getCandidates()[0]->getUrl());
      }
      else {
        #vids
        if ($storyItems[$i]->getStoryCta()==null) {
           echo " ";
        }
        else {
            echo " & <a href='".$storyItems[$i]->getStoryCta()[0]->getLinks()[0]->getWebUri()."'>webUri</a>";
        }
      getVideoHTML($storyItems[$i]->getVideoVersions()[0]->getUrl());
      }
    }
} catch (\Exception $e) {
    echo 'Something went wrong: '.$e->getMessage()."\n";
    exit(0);
}
