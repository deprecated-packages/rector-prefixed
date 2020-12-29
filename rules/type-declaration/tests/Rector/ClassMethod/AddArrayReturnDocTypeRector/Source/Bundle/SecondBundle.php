<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddArrayReturnDocTypeRector\Source\Bundle;

use RectorPrefix20201229\Symfony\Component\DependencyInjection\ContainerBuilder;
use RectorPrefix20201229\Symfony\Component\DependencyInjection\ContainerInterface;
use RectorPrefix20201229\Symfony\Component\HttpKernel\Bundle\BundleInterface;
final class SecondBundle implements \RectorPrefix20201229\Symfony\Component\HttpKernel\Bundle\BundleInterface
{
    public function boot()
    {
    }
    public function shutdown()
    {
    }
    public function build(\RectorPrefix20201229\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
    }
    public function getContainerExtension()
    {
    }
    public function getName()
    {
    }
    public function getNamespace()
    {
    }
    public function getPath()
    {
    }
    public function setContainer(\RectorPrefix20201229\Symfony\Component\DependencyInjection\ContainerInterface $container = null)
    {
    }
}
