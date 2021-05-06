<?php

declare (strict_types=1);
namespace RectorPrefix20210506\Symplify\ConsoleColorDiff\DependencyInjection\Extension;

use RectorPrefix20210506\Symfony\Component\Config\FileLocator;
use RectorPrefix20210506\Symfony\Component\DependencyInjection\ContainerBuilder;
use RectorPrefix20210506\Symfony\Component\DependencyInjection\Extension\Extension;
use RectorPrefix20210506\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
final class ConsoleColorDiffExtension extends \RectorPrefix20210506\Symfony\Component\DependencyInjection\Extension\Extension
{
    /**
     * @param string[] $configs
     */
    public function load(array $configs, \RectorPrefix20210506\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $phpFileLoader = new \RectorPrefix20210506\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \RectorPrefix20210506\Symfony\Component\Config\FileLocator(__DIR__ . '/../../../config'));
        $phpFileLoader->load('config.php');
    }
}
