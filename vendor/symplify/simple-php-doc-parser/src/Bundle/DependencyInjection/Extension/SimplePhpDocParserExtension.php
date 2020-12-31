<?php

declare (strict_types=1);
namespace RectorPrefix20201231\Symplify\SimplePhpDocParser\Bundle\DependencyInjection\Extension;

use RectorPrefix20201231\Symfony\Component\Config\FileLocator;
use RectorPrefix20201231\Symfony\Component\DependencyInjection\ContainerBuilder;
use RectorPrefix20201231\Symfony\Component\DependencyInjection\Extension\Extension;
use RectorPrefix20201231\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
final class SimplePhpDocParserExtension extends \RectorPrefix20201231\Symfony\Component\DependencyInjection\Extension\Extension
{
    public function load(array $configs, \RectorPrefix20201231\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $phpFileLoader = new \RectorPrefix20201231\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \RectorPrefix20201231\Symfony\Component\Config\FileLocator(__DIR__ . '/../../../../config'));
        $phpFileLoader->load('config.php');
    }
}
