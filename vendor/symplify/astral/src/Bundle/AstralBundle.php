<?php

declare (strict_types=1);
namespace RectorPrefix20210315\Symplify\Astral\Bundle;

use RectorPrefix20210315\Symfony\Component\DependencyInjection\ContainerBuilder;
use RectorPrefix20210315\Symfony\Component\HttpKernel\Bundle\Bundle;
use RectorPrefix20210315\Symplify\Astral\DependencyInjection\Extension\AstralExtension;
use RectorPrefix20210315\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;
final class AstralBundle extends \RectorPrefix20210315\Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function build(\RectorPrefix20210315\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $containerBuilder->addCompilerPass(new \RectorPrefix20210315\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass());
    }
    protected function createContainerExtension() : \RectorPrefix20210315\Symplify\Astral\DependencyInjection\Extension\AstralExtension
    {
        return new \RectorPrefix20210315\Symplify\Astral\DependencyInjection\Extension\AstralExtension();
    }
}
