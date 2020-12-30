<?php

declare (strict_types=1);
namespace RectorPrefix20201230\Symplify\MarkdownDiff\DependencyInjection\Extension;

use RectorPrefix20201230\Symfony\Component\Config\FileLocator;
use RectorPrefix20201230\Symfony\Component\DependencyInjection\ContainerBuilder;
use RectorPrefix20201230\Symfony\Component\DependencyInjection\Extension\Extension;
use RectorPrefix20201230\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
final class MarkdownDiffExtension extends \RectorPrefix20201230\Symfony\Component\DependencyInjection\Extension\Extension
{
    public function load(array $configs, \RectorPrefix20201230\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $phpFileLoader = new \RectorPrefix20201230\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \RectorPrefix20201230\Symfony\Component\Config\FileLocator(__DIR__ . '/../../../config'));
        $phpFileLoader->load('config.php');
    }
}
