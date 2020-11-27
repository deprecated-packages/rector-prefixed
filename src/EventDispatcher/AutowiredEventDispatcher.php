<?php

declare (strict_types=1);
namespace Rector\Core\EventDispatcher;

use Rector\Core\ValueObject\MethodName;
use _PhpScoper26e51eeacccf\Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
final class AutowiredEventDispatcher extends \_PhpScoper26e51eeacccf\Symfony\Component\EventDispatcher\EventDispatcher
{
    /**
     * @param EventSubscriberInterface[] $eventSubscribers
     */
    public function __construct(array $eventSubscribers)
    {
        foreach ($eventSubscribers as $eventSubscriber) {
            $this->addSubscriber($eventSubscriber);
        }
        // Symfony 4.4/5 compat
        if (\method_exists(parent::class, \Rector\Core\ValueObject\MethodName::CONSTRUCT)) {
            parent::__construct();
        }
    }
}
