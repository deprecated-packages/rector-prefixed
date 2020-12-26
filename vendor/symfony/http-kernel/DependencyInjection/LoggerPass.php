<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix2020DecSat\Symfony\Component\HttpKernel\DependencyInjection;

use RectorPrefix2020DecSat\Psr\Log\LoggerInterface;
use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\ContainerBuilder;
use RectorPrefix2020DecSat\Symfony\Component\HttpKernel\Log\Logger;
/**
 * Registers the default logger if necessary.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class LoggerPass implements \RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(\RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        $container->setAlias(\RectorPrefix2020DecSat\Psr\Log\LoggerInterface::class, 'logger')->setPublic(\false);
        if ($container->has('logger')) {
            return;
        }
        $container->register('logger', \RectorPrefix2020DecSat\Symfony\Component\HttpKernel\Log\Logger::class)->setPublic(\false);
    }
}
