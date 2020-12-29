<?php

declare (strict_types=1);
namespace RectorPrefix20201229\Symplify\SymplifyKernel\Bundle;

use RectorPrefix20201229\Symfony\Component\DependencyInjection\ContainerBuilder;
use RectorPrefix20201229\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use RectorPrefix20201229\Symfony\Component\HttpKernel\Bundle\Bundle;
use RectorPrefix20201229\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;
use RectorPrefix20201229\Symplify\SymplifyKernel\DependencyInjection\CompilerPass\PrepareConsoleApplicationCompilerPass;
use RectorPrefix20201229\Symplify\SymplifyKernel\DependencyInjection\Extension\SymplifyKernelExtension;
final class SymplifyKernelBundle extends \RectorPrefix20201229\Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function build(\RectorPrefix20201229\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $containerBuilder->addCompilerPass(new \RectorPrefix20201229\Symplify\SymplifyKernel\DependencyInjection\CompilerPass\PrepareConsoleApplicationCompilerPass());
        $containerBuilder->addCompilerPass(new \RectorPrefix20201229\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass());
    }
    protected function createContainerExtension() : ?\RectorPrefix20201229\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \RectorPrefix20201229\Symplify\SymplifyKernel\DependencyInjection\Extension\SymplifyKernelExtension();
    }
}
