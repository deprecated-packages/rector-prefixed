<?php

declare(strict_types=1);

namespace Symplify\SymplifyKernel\Bundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;
use Symplify\SymplifyKernel\DependencyInjection\CompilerPass\PrepareConsoleApplicationCompilerPass;
use Symplify\SymplifyKernel\DependencyInjection\Extension\SymplifyKernelExtension;

final class SymplifyKernelBundle extends Bundle
{
    public function build(ContainerBuilder $containerBuilder): void
    {
        $containerBuilder->addCompilerPass(new PrepareConsoleApplicationCompilerPass());

        $containerBuilder->addCompilerPass(new AutowireArrayParameterCompilerPass());
    }

    protected function createContainerExtension(): SymplifyKernelExtension
    {
        return new SymplifyKernelExtension();
    }
}
