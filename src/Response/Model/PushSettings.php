<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method mixed getChecked()
 * @method mixed getEligible()
 * @method mixed getExample()
 * @method mixed getName()
 * @method mixed getOptions()
 * @method mixed getTitle()
 * @method bool isChecked()
 * @method bool isEligible()
 * @method bool isExample()
 * @method bool isName()
 * @method bool isOptions()
 * @method bool isTitle()
 * @method setChecked(mixed $value)
 * @method setEligible(mixed $value)
 * @method setExample(mixed $value)
 * @method setName(mixed $value)
 * @method setOptions(mixed $value)
 * @method setTitle(mixed $value)
 */
class PushSettings extends AutoPropertyHandler
{
    public $name;
    public $eligible;
    public $title;
    public $example;
    public $options;
    public $checked;
}
