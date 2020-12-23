<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Symplify\SymplifyKernel\DependencyInjection\CompilerPass;

use _PhpScoper0a2ac50786fa\Symfony\Component\Console\Application;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Reference;
use _PhpScoper0a2ac50786fa\Symplify\SymplifyKernel\Console\AutowiredConsoleApplication;
use _PhpScoper0a2ac50786fa\Symplify\SymplifyKernel\Console\ConsoleApplicationFactory;
final class PrepareConsoleApplicationCompilerPass implements \_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    public function process(\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $consoleApplicationClass = $this->resolveConsoleApplicationClass($containerBuilder);
        if ($consoleApplicationClass === null) {
            $this->registerAutowiredSymfonyConsole($containerBuilder);
            return;
        }
        // add console application alias
        if ($consoleApplicationClass === \_PhpScoper0a2ac50786fa\Symfony\Component\Console\Application::class) {
            return;
        }
        $containerBuilder->setAlias(\_PhpScoper0a2ac50786fa\Symfony\Component\Console\Application::class, $consoleApplicationClass)->setPublic(\true);
        // calls
        // resolve name
        // resolve version
    }
    private function resolveConsoleApplicationClass(\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : ?string
    {
        foreach ($containerBuilder->getDefinitions() as $definition) {
            if (!\is_a((string) $definition->getClass(), \_PhpScoper0a2ac50786fa\Symfony\Component\Console\Application::class, \true)) {
                continue;
            }
            return $definition->getClass();
        }
        return null;
    }
    /**
     * Missing console application? add basic one
     */
    private function registerAutowiredSymfonyConsole(\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $containerBuilder->autowire(\_PhpScoper0a2ac50786fa\Symplify\SymplifyKernel\Console\AutowiredConsoleApplication::class, \_PhpScoper0a2ac50786fa\Symplify\SymplifyKernel\Console\AutowiredConsoleApplication::class)->setFactory([new \_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Reference(\_PhpScoper0a2ac50786fa\Symplify\SymplifyKernel\Console\ConsoleApplicationFactory::class), 'create']);
        $containerBuilder->setAlias(\_PhpScoper0a2ac50786fa\Symfony\Component\Console\Application::class, \_PhpScoper0a2ac50786fa\Symplify\SymplifyKernel\Console\AutowiredConsoleApplication::class)->setPublic(\true);
    }
}
