<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method Model\FaceModels getFaceModels()
 * @method bool isFaceModels()
 * @method setFaceModels(Model\FaceModels $value)
 */
class FaceModelsResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    /**
     * @var Model\FaceModels
     */
    public $face_models;
}
