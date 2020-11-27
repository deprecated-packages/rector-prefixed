<?php

declare (strict_types=1);
namespace Symplify\Skipper\DependencyInjection\Extension;

use _PhpScoperbd5d0c5f7638\Symfony\Component\Config\FileLocator;
use _PhpScoperbd5d0c5f7638\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoperbd5d0c5f7638\Symfony\Component\DependencyInjection\Extension\Extension;
use _PhpScoperbd5d0c5f7638\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
final class SkipperExtension extends \_PhpScoperbd5d0c5f7638\Symfony\Component\DependencyInjection\Extension\Extension
{
    public function load(array $configs, \_PhpScoperbd5d0c5f7638\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        // needed for parameter shifting of sniff/fixer params
        $phpFileLoader = new \_PhpScoperbd5d0c5f7638\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \_PhpScoperbd5d0c5f7638\Symfony\Component\Config\FileLocator(__DIR__ . '/../../../config'));
        $phpFileLoader->load('config.php');
    }
}
