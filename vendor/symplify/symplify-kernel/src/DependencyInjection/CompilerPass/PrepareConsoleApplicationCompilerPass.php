<?php

declare(strict_types=1);

namespace Symplify\SymplifyKernel\DependencyInjection\CompilerPass;

use Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symplify\SymplifyKernel\Console\AutowiredConsoleApplication;
use Symplify\SymplifyKernel\Console\ConsoleApplicationFactory;

final class PrepareConsoleApplicationCompilerPass implements CompilerPassInterface
{
    /**
     * @return void
     */
    public function process(ContainerBuilder $containerBuilder)
    {
        $consoleApplicationClass = $this->resolveConsoleApplicationClass($containerBuilder);
        if ($consoleApplicationClass === null) {
            $this->registerAutowiredSymfonyConsole($containerBuilder);
            return;
        }

        // add console application alias
        if ($consoleApplicationClass === Application::class) {
            return;
        }

        $containerBuilder->setAlias(Application::class, $consoleApplicationClass)
            ->setPublic(true);

        // calls
        // resolve name
        // resolve version
    }

    /**
     * @return string|null
     */
    private function resolveConsoleApplicationClass(ContainerBuilder $containerBuilder)
    {
        foreach ($containerBuilder->getDefinitions() as $definition) {
            if (! is_a((string) $definition->getClass(), Application::class, true)) {
                continue;
            }

            return $definition->getClass();
        }

        return null;
    }

    /**
     * Missing console application? add basic one
     * @return void
     */
    private function registerAutowiredSymfonyConsole(ContainerBuilder $containerBuilder)
    {
        $containerBuilder->autowire(AutowiredConsoleApplication::class, AutowiredConsoleApplication::class)
            ->setFactory([new Reference(ConsoleApplicationFactory::class), 'create']);

        $containerBuilder->setAlias(Application::class, AutowiredConsoleApplication::class)
            ->setPublic(true);
    }
}
