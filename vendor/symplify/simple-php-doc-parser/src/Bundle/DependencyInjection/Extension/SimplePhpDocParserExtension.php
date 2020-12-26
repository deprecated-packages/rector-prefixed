<?php

declare (strict_types=1);
namespace Symplify\SimplePhpDocParser\Bundle\DependencyInjection\Extension;

use RectorPrefix2020DecSat\Symfony\Component\Config\FileLocator;
use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\ContainerBuilder;
use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Extension\Extension;
use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
final class SimplePhpDocParserExtension extends \RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Extension\Extension
{
    public function load(array $configs, \RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $phpFileLoader = new \RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \RectorPrefix2020DecSat\Symfony\Component\Config\FileLocator(__DIR__ . '/../../../../config'));
        $phpFileLoader->load('config.php');
    }
}
