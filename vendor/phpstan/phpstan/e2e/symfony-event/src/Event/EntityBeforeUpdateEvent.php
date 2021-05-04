<?php

namespace RectorPrefix20210504\App\Event;

use RectorPrefix20210504\Symfony\Contracts\EventDispatcher\Event;
class EntityBeforeUpdateEvent extends \RectorPrefix20210504\Symfony\Contracts\EventDispatcher\Event
{
    public const NAME = 'entity.beforeUpdate';
}
