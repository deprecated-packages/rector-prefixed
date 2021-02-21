<?php

declare (strict_types=1);
namespace RectorPrefix20210221\Symplify\PhpConfigPrinter\DependencyInjection\Extension;

use RectorPrefix20210221\Symfony\Component\Config\FileLocator;
use RectorPrefix20210221\Symfony\Component\DependencyInjection\ContainerBuilder;
use RectorPrefix20210221\Symfony\Component\DependencyInjection\Extension\Extension;
use RectorPrefix20210221\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
final class PhpConfigPrinterExtension extends \RectorPrefix20210221\Symfony\Component\DependencyInjection\Extension\Extension
{
    public function load(array $configs, \RectorPrefix20210221\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        // needed for parameter shifting of sniff/fixer params
        $phpFileLoader = new \RectorPrefix20210221\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \RectorPrefix20210221\Symfony\Component\Config\FileLocator(__DIR__ . '/../../../config'));
        $phpFileLoader->load('config.php');
    }
}
