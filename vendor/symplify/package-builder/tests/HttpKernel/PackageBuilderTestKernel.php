<?php

declare (strict_types=1);
namespace RectorPrefix20210311\Symplify\PackageBuilder\Tests\HttpKernel;

use RectorPrefix20210311\Symfony\Component\DependencyInjection\ContainerBuilder;
use RectorPrefix20210311\Symplify\PackageBuilder\Parameter\ParameterProvider;
use RectorPrefix20210311\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class PackageBuilderTestKernel extends \RectorPrefix20210311\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    protected function build(\RectorPrefix20210311\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $containerBuilder->autowire(\RectorPrefix20210311\Symplify\PackageBuilder\Parameter\ParameterProvider::class)->setPublic(\true);
    }
}
