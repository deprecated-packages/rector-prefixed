<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Symplify\SymplifyKernel\Bundle;

use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use _PhpScoperb75b35f52b74\Symfony\Component\HttpKernel\Bundle\Bundle;
use _PhpScoperb75b35f52b74\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;
use _PhpScoperb75b35f52b74\Symplify\SymplifyKernel\DependencyInjection\CompilerPass\PrepareConsoleApplicationCompilerPass;
use _PhpScoperb75b35f52b74\Symplify\SymplifyKernel\DependencyInjection\Extension\SymplifyKernelExtension;
final class SymplifyKernelBundle extends \_PhpScoperb75b35f52b74\Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function build(\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $containerBuilder->addCompilerPass(new \_PhpScoperb75b35f52b74\Symplify\SymplifyKernel\DependencyInjection\CompilerPass\PrepareConsoleApplicationCompilerPass());
        $containerBuilder->addCompilerPass(new \_PhpScoperb75b35f52b74\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass());
    }
    protected function createContainerExtension() : ?\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \_PhpScoperb75b35f52b74\Symplify\SymplifyKernel\DependencyInjection\Extension\SymplifyKernelExtension();
    }
}
