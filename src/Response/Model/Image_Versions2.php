<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method ImageCandidate[] getCandidates()
 * @method bool isCandidates()
 * @method setCandidates(ImageCandidate[] $value)
 */
class Image_Versions2 extends AutoPropertyHandler
{
    /**
     * @var ImageCandidate[]
     */
    public $candidates;
}
