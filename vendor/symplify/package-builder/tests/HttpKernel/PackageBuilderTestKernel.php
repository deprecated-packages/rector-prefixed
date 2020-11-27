<?php

declare (strict_types=1);
namespace Symplify\PackageBuilder\Tests\HttpKernel;

use _PhpScoper88fe6e0ad041\Symfony\Component\DependencyInjection\ContainerBuilder;
use Symplify\PackageBuilder\Parameter\ParameterProvider;
use Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class PackageBuilderTestKernel extends \Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    protected function build(\_PhpScoper88fe6e0ad041\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $containerBuilder->autowire(\Symplify\PackageBuilder\Parameter\ParameterProvider::class)->setPublic(\true);
    }
}
