<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\SymplifyKernel\DependencyInjection\CompilerPass;

use _PhpScopere8e811afab72\Symfony\Component\Console\Application;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Reference;
use _PhpScopere8e811afab72\Symplify\SymplifyKernel\Console\AutowiredConsoleApplication;
use _PhpScopere8e811afab72\Symplify\SymplifyKernel\Console\ConsoleApplicationFactory;
final class PrepareConsoleApplicationCompilerPass implements \_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    public function process(\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $consoleApplicationClass = $this->resolveConsoleApplicationClass($containerBuilder);
        if ($consoleApplicationClass === null) {
            $this->registerAutowiredSymfonyConsole($containerBuilder);
            return;
        }
        // add console application alias
        if ($consoleApplicationClass === \_PhpScopere8e811afab72\Symfony\Component\Console\Application::class) {
            return;
        }
        $containerBuilder->setAlias(\_PhpScopere8e811afab72\Symfony\Component\Console\Application::class, $consoleApplicationClass)->setPublic(\true);
        // calls
        // resolve name
        // resolve version
    }
    private function resolveConsoleApplicationClass(\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : ?string
    {
        foreach ($containerBuilder->getDefinitions() as $definition) {
            if (!\is_a((string) $definition->getClass(), \_PhpScopere8e811afab72\Symfony\Component\Console\Application::class, \true)) {
                continue;
            }
            return $definition->getClass();
        }
        return null;
    }
    /**
     * Missing console application? add basic one
     */
    private function registerAutowiredSymfonyConsole(\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $containerBuilder->autowire(\_PhpScopere8e811afab72\Symplify\SymplifyKernel\Console\AutowiredConsoleApplication::class, \_PhpScopere8e811afab72\Symplify\SymplifyKernel\Console\AutowiredConsoleApplication::class)->setFactory([new \_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Reference(\_PhpScopere8e811afab72\Symplify\SymplifyKernel\Console\ConsoleApplicationFactory::class), 'create']);
        $containerBuilder->setAlias(\_PhpScopere8e811afab72\Symfony\Component\Console\Application::class, \_PhpScopere8e811afab72\Symplify\SymplifyKernel\Console\AutowiredConsoleApplication::class)->setPublic(\true);
    }
}
