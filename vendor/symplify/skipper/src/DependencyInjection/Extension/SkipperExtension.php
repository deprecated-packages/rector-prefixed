<?php

declare (strict_types=1);
namespace RectorPrefix20210421\Symplify\Skipper\DependencyInjection\Extension;

use RectorPrefix20210421\Symfony\Component\Config\FileLocator;
use RectorPrefix20210421\Symfony\Component\DependencyInjection\ContainerBuilder;
use RectorPrefix20210421\Symfony\Component\DependencyInjection\Extension\Extension;
use RectorPrefix20210421\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
final class SkipperExtension extends \RectorPrefix20210421\Symfony\Component\DependencyInjection\Extension\Extension
{
    /**
     * @param string[] $configs
     * @return void
     */
    public function load(array $configs, \RectorPrefix20210421\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder)
    {
        // needed for parameter shifting of sniff/fixer params
        $phpFileLoader = new \RectorPrefix20210421\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \RectorPrefix20210421\Symfony\Component\Config\FileLocator(__DIR__ . '/../../../config'));
        $phpFileLoader->load('config.php');
    }
}
