<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Symplify\SymplifyKernel\Bundle;

use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use _PhpScoper0a2ac50786fa\Symfony\Component\HttpKernel\Bundle\Bundle;
use _PhpScoper0a2ac50786fa\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;
use _PhpScoper0a2ac50786fa\Symplify\SymplifyKernel\DependencyInjection\CompilerPass\PrepareConsoleApplicationCompilerPass;
use _PhpScoper0a2ac50786fa\Symplify\SymplifyKernel\DependencyInjection\Extension\SymplifyKernelExtension;
final class SymplifyKernelBundle extends \_PhpScoper0a2ac50786fa\Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function build(\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $containerBuilder->addCompilerPass(new \_PhpScoper0a2ac50786fa\Symplify\SymplifyKernel\DependencyInjection\CompilerPass\PrepareConsoleApplicationCompilerPass());
        $containerBuilder->addCompilerPass(new \_PhpScoper0a2ac50786fa\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass());
    }
    protected function createContainerExtension() : ?\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\SymplifyKernel\DependencyInjection\Extension\SymplifyKernelExtension();
    }
}
