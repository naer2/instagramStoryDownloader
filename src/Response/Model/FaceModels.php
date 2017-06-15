<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method mixed getFaceAlignModel()
 * @method mixed getFaceDetectModel()
 * @method mixed getPdmMultires()
 * @method bool isFaceAlignModel()
 * @method bool isFaceDetectModel()
 * @method bool isPdmMultires()
 * @method setFaceAlignModel(mixed $value)
 * @method setFaceDetectModel(mixed $value)
 * @method setPdmMultires(mixed $value)
 */
class FaceModels extends AutoPropertyHandler
{
    public $face_align_model;
    public $face_detect_model;
    public $pdm_multires;
}
