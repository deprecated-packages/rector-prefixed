<?php

declare(strict_types=1);

namespace Symplify\SimplePhpDocParser\Bundle\DependencyInjection\Extension;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

final class SimplePhpDocParserExtension extends Extension
{
    /**
     * @param string[] $configs
     * @return void
     */
    public function load(array $configs, ContainerBuilder $containerBuilder)
    {
        $phpFileLoader = new PhpFileLoader($containerBuilder, new FileLocator(__DIR__ . '/../../../../config'));
        $phpFileLoader->load('config.php');
    }
}
