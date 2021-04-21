<?php

declare(strict_types=1);

namespace Symplify\Astral\Bundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symplify\Astral\DependencyInjection\Extension\AstralExtension;
use Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;

final class AstralBundle extends Bundle
{
    /**
     * @return void
     */
    public function build(ContainerBuilder $containerBuilder)
    {
        $containerBuilder->addCompilerPass(new AutowireArrayParameterCompilerPass());
    }

    /**
     * @return \Symfony\Component\DependencyInjection\Extension\ExtensionInterface|null
     */
    protected function createContainerExtension()
    {
        return new AstralExtension();
    }
}
