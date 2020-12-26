<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix2020DecSat\Symfony\Component\EventDispatcher;

use RectorPrefix2020DecSat\Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
trigger_deprecation('symfony/event-dispatcher', '5.1', '%s is deprecated, use the event dispatcher without the proxy.', \RectorPrefix2020DecSat\Symfony\Component\EventDispatcher\LegacyEventDispatcherProxy::class);
/**
 * A helper class to provide BC/FC with the legacy signature of EventDispatcherInterface::dispatch().
 *
 * @author Nicolas Grekas <p@tchwork.com>
 *
 * @deprecated since Symfony 5.1
 */
final class LegacyEventDispatcherProxy
{
    public static function decorate(?\RectorPrefix2020DecSat\Symfony\Contracts\EventDispatcher\EventDispatcherInterface $dispatcher) : ?\RectorPrefix2020DecSat\Symfony\Contracts\EventDispatcher\EventDispatcherInterface
    {
        return $dispatcher;
    }
}
