<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method Model\Experiment[] getExperiments()
 * @method bool isExperiments()
 * @method setExperiments(Model\Experiment[] $value)
 */
class SyncResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    /**
     * @var Model\Experiment[]
     */
    public $experiments;
}
