<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\SymplifyKernel\Bundle;

use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use _PhpScopere8e811afab72\Symfony\Component\HttpKernel\Bundle\Bundle;
use _PhpScopere8e811afab72\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;
use _PhpScopere8e811afab72\Symplify\SymplifyKernel\DependencyInjection\CompilerPass\PrepareConsoleApplicationCompilerPass;
use _PhpScopere8e811afab72\Symplify\SymplifyKernel\DependencyInjection\Extension\SymplifyKernelExtension;
final class SymplifyKernelBundle extends \_PhpScopere8e811afab72\Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function build(\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $containerBuilder->addCompilerPass(new \_PhpScopere8e811afab72\Symplify\SymplifyKernel\DependencyInjection\CompilerPass\PrepareConsoleApplicationCompilerPass());
        $containerBuilder->addCompilerPass(new \_PhpScopere8e811afab72\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass());
    }
    protected function createContainerExtension() : ?\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \_PhpScopere8e811afab72\Symplify\SymplifyKernel\DependencyInjection\Extension\SymplifyKernelExtension();
    }
}
