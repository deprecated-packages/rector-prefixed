<?php

declare (strict_types=1);
namespace RectorPrefix20210318\Symplify\SymplifyKernel\Bundle;

use RectorPrefix20210318\Symfony\Component\DependencyInjection\ContainerBuilder;
use RectorPrefix20210318\Symfony\Component\HttpKernel\Bundle\Bundle;
use RectorPrefix20210318\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;
use RectorPrefix20210318\Symplify\SymplifyKernel\DependencyInjection\CompilerPass\PrepareConsoleApplicationCompilerPass;
use RectorPrefix20210318\Symplify\SymplifyKernel\DependencyInjection\Extension\SymplifyKernelExtension;
final class SymplifyKernelBundle extends \RectorPrefix20210318\Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function build(\RectorPrefix20210318\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $containerBuilder->addCompilerPass(new \RectorPrefix20210318\Symplify\SymplifyKernel\DependencyInjection\CompilerPass\PrepareConsoleApplicationCompilerPass());
        $containerBuilder->addCompilerPass(new \RectorPrefix20210318\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass());
    }
    protected function createContainerExtension() : \RectorPrefix20210318\Symplify\SymplifyKernel\DependencyInjection\Extension\SymplifyKernelExtension
    {
        return new \RectorPrefix20210318\Symplify\SymplifyKernel\DependencyInjection\Extension\SymplifyKernelExtension();
    }
}
