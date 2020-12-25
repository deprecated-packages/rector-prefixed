<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper5edc98a7cce2\Symfony\Component\DependencyInjection\Compiler;

use _PhpScoper5edc98a7cce2\Psr\Container\ContainerInterface;
use _PhpScoper5edc98a7cce2\Symfony\Component\DependencyInjection\Definition;
use _PhpScoper5edc98a7cce2\Symfony\Component\DependencyInjection\Reference;
use _PhpScoper5edc98a7cce2\Symfony\Contracts\Service\ServiceProviderInterface;
/**
 * Compiler pass to inject their service locator to service subscribers.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
class ResolveServiceSubscribersPass extends \_PhpScoper5edc98a7cce2\Symfony\Component\DependencyInjection\Compiler\AbstractRecursivePass
{
    private $serviceLocator;
    protected function processValue($value, bool $isRoot = \false)
    {
        if ($value instanceof \_PhpScoper5edc98a7cce2\Symfony\Component\DependencyInjection\Reference && $this->serviceLocator && \in_array((string) $value, [\_PhpScoper5edc98a7cce2\Psr\Container\ContainerInterface::class, \_PhpScoper5edc98a7cce2\Symfony\Contracts\Service\ServiceProviderInterface::class], \true)) {
            return new \_PhpScoper5edc98a7cce2\Symfony\Component\DependencyInjection\Reference($this->serviceLocator);
        }
        if (!$value instanceof \_PhpScoper5edc98a7cce2\Symfony\Component\DependencyInjection\Definition) {
            return parent::processValue($value, $isRoot);
        }
        $serviceLocator = $this->serviceLocator;
        $this->serviceLocator = null;
        if ($value->hasTag('container.service_subscriber.locator')) {
            $this->serviceLocator = $value->getTag('container.service_subscriber.locator')[0]['id'];
            $value->clearTag('container.service_subscriber.locator');
        }
        try {
            return parent::processValue($value);
        } finally {
            $this->serviceLocator = $serviceLocator;
        }
    }
}
