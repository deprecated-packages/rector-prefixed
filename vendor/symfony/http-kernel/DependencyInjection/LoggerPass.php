<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210504\Symfony\Component\HttpKernel\DependencyInjection;

use RectorPrefix20210504\Psr\Log\LoggerInterface;
use RectorPrefix20210504\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use RectorPrefix20210504\Symfony\Component\DependencyInjection\ContainerBuilder;
use RectorPrefix20210504\Symfony\Component\HttpKernel\Log\Logger;
/**
 * Registers the default logger if necessary.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class LoggerPass implements \RectorPrefix20210504\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(\RectorPrefix20210504\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        $container->setAlias(\RectorPrefix20210504\Psr\Log\LoggerInterface::class, 'logger')->setPublic(\false);
        if ($container->has('logger')) {
            return;
        }
        $container->register('logger', \RectorPrefix20210504\Symfony\Component\HttpKernel\Log\Logger::class)->setPublic(\false);
    }
}
