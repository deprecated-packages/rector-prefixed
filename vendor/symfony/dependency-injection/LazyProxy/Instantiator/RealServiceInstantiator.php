<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\LazyProxy\Instantiator;

use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\ContainerInterface;
use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Definition;
/**
 * {@inheritdoc}
 *
 * Noop proxy instantiator - produces the real service instead of a proxy instance.
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 */
class RealServiceInstantiator implements \RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\LazyProxy\Instantiator\InstantiatorInterface
{
    /**
     * {@inheritdoc}
     */
    public function instantiateProxy(\RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\ContainerInterface $container, \RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Definition $definition, string $id, callable $realInstantiator)
    {
        return $realInstantiator();
    }
}
