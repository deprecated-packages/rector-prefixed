<?php

declare (strict_types=1);
namespace RectorPrefix20210318\Symplify\SymplifyKernel\DependencyInjection\CompilerPass;

use RectorPrefix20210318\Symfony\Component\Console\Application;
use RectorPrefix20210318\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use RectorPrefix20210318\Symfony\Component\DependencyInjection\ContainerBuilder;
use RectorPrefix20210318\Symfony\Component\DependencyInjection\Reference;
use RectorPrefix20210318\Symplify\SymplifyKernel\Console\AutowiredConsoleApplication;
use RectorPrefix20210318\Symplify\SymplifyKernel\Console\ConsoleApplicationFactory;
final class PrepareConsoleApplicationCompilerPass implements \RectorPrefix20210318\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder
     */
    public function process($containerBuilder) : void
    {
        $consoleApplicationClass = $this->resolveConsoleApplicationClass($containerBuilder);
        if ($consoleApplicationClass === null) {
            $this->registerAutowiredSymfonyConsole($containerBuilder);
            return;
        }
        // add console application alias
        if ($consoleApplicationClass === \RectorPrefix20210318\Symfony\Component\Console\Application::class) {
            return;
        }
        $containerBuilder->setAlias(\RectorPrefix20210318\Symfony\Component\Console\Application::class, $consoleApplicationClass)->setPublic(\true);
        // calls
        // resolve name
        // resolve version
    }
    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder
     */
    private function resolveConsoleApplicationClass($containerBuilder) : ?string
    {
        foreach ($containerBuilder->getDefinitions() as $definition) {
            if (!\is_a((string) $definition->getClass(), \RectorPrefix20210318\Symfony\Component\Console\Application::class, \true)) {
                continue;
            }
            return $definition->getClass();
        }
        return null;
    }
    /**
     * Missing console application? add basic one
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder
     */
    private function registerAutowiredSymfonyConsole($containerBuilder) : void
    {
        $containerBuilder->autowire(\RectorPrefix20210318\Symplify\SymplifyKernel\Console\AutowiredConsoleApplication::class, \RectorPrefix20210318\Symplify\SymplifyKernel\Console\AutowiredConsoleApplication::class)->setFactory([new \RectorPrefix20210318\Symfony\Component\DependencyInjection\Reference(\RectorPrefix20210318\Symplify\SymplifyKernel\Console\ConsoleApplicationFactory::class), 'create']);
        $containerBuilder->setAlias(\RectorPrefix20210318\Symfony\Component\Console\Application::class, \RectorPrefix20210318\Symplify\SymplifyKernel\Console\AutowiredConsoleApplication::class)->setPublic(\true);
    }
}
