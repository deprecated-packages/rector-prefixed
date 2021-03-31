<?php

declare (strict_types=1);
namespace RectorPrefix20210331\Symplify\Astral\DependencyInjection\Extension;

use RectorPrefix20210331\Symfony\Component\Config\FileLocator;
use RectorPrefix20210331\Symfony\Component\DependencyInjection\ContainerBuilder;
use RectorPrefix20210331\Symfony\Component\DependencyInjection\Extension\Extension;
use RectorPrefix20210331\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
final class AstralExtension extends \RectorPrefix20210331\Symfony\Component\DependencyInjection\Extension\Extension
{
    /**
     * @param string[] $configs
     */
    public function load(array $configs, \RectorPrefix20210331\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $phpFileLoader = new \RectorPrefix20210331\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \RectorPrefix20210331\Symfony\Component\Config\FileLocator(__DIR__ . '/../../../config'));
        $phpFileLoader->load('config.php');
    }
}
