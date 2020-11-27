<?php

declare (strict_types=1);
namespace Symplify\PackageBuilder\Tests\HttpKernel;

use _PhpScoperbd5d0c5f7638\Symfony\Component\DependencyInjection\ContainerBuilder;
use Symplify\PackageBuilder\Parameter\ParameterProvider;
use Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class PackageBuilderTestKernel extends \Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    protected function build(\_PhpScoperbd5d0c5f7638\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $containerBuilder->autowire(\Symplify\PackageBuilder\Parameter\ParameterProvider::class)->setPublic(\true);
    }
}
