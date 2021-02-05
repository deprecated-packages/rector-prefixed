<?php

declare (strict_types=1);
namespace RectorPrefix20210205\Symplify\SymplifyKernel\DependencyInjection\Extension;

use RectorPrefix20210205\Symfony\Component\Config\FileLocator;
use RectorPrefix20210205\Symfony\Component\DependencyInjection\ContainerBuilder;
use RectorPrefix20210205\Symfony\Component\DependencyInjection\Extension\Extension;
use RectorPrefix20210205\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
final class SymplifyKernelExtension extends \RectorPrefix20210205\Symfony\Component\DependencyInjection\Extension\Extension
{
    public function load(array $configs, \RectorPrefix20210205\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $phpFileLoader = new \RectorPrefix20210205\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \RectorPrefix20210205\Symfony\Component\Config\FileLocator(__DIR__ . '/../../../config'));
        $phpFileLoader->load('common-config.php');
    }
}
