<?php

declare (strict_types=1);
namespace RectorPrefix20210309\Symplify\Astral\Bundle;

use RectorPrefix20210309\Symfony\Component\DependencyInjection\ContainerBuilder;
use RectorPrefix20210309\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use RectorPrefix20210309\Symfony\Component\HttpKernel\Bundle\Bundle;
use RectorPrefix20210309\Symplify\Astral\DependencyInjection\Extension\AstralExtension;
use RectorPrefix20210309\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;
final class AstralBundle extends \RectorPrefix20210309\Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function build(\RectorPrefix20210309\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $containerBuilder->addCompilerPass(new \RectorPrefix20210309\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass());
    }
    protected function createContainerExtension() : ?\RectorPrefix20210309\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \RectorPrefix20210309\Symplify\Astral\DependencyInjection\Extension\AstralExtension();
    }
}
