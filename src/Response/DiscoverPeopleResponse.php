<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method Model\Groups[] getGroups()
 * @method string getMaxId()
 * @method mixed getMoreAvailable()
 * @method bool isGroups()
 * @method bool isMaxId()
 * @method bool isMoreAvailable()
 * @method setGroups(Model\Groups[] $value)
 * @method setMaxId(string $value)
 * @method setMoreAvailable(mixed $value)
 */
class DiscoverPeopleResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    /**
     * @var Model\Groups[]
     */
    public $groups;
    public $more_available;
    /**
     * @var string
     */
    public $max_id;
}
