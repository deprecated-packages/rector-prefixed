<?php

declare (strict_types=1);
namespace RectorPrefix20210407\Symplify\PackageBuilder\Tests\HttpKernel;

use RectorPrefix20210407\Symfony\Component\DependencyInjection\ContainerBuilder;
use RectorPrefix20210407\Symplify\PackageBuilder\Parameter\ParameterProvider;
use RectorPrefix20210407\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class PackageBuilderTestKernel extends \RectorPrefix20210407\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    protected function build(\RectorPrefix20210407\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $containerBuilder->autowire(\RectorPrefix20210407\Symplify\PackageBuilder\Parameter\ParameterProvider::class)->setPublic(\true);
    }
}
