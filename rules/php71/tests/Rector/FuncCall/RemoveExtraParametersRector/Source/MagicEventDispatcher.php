<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Php71\Tests\Rector\FuncCall\RemoveExtraParametersRector\Source;

use _PhpScoperb75b35f52b74\Symfony\Component\EventDispatcher\Event;
use _PhpScoperb75b35f52b74\Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
final class MagicEventDispatcher
{
    /**
     * {@inheritdoc}
     *
     * @param string|null $eventName
     */
    public function dispatch($event)
    {
        $eventName = 1 < \func_num_args() ? \func_get_arg(1) : null;
    }
}
