<?php

declare (strict_types=1);
namespace Symplify\MarkdownDiff\DependencyInjection\Extension;

use _PhpScoper88fe6e0ad041\Symfony\Component\Config\FileLocator;
use _PhpScoper88fe6e0ad041\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoper88fe6e0ad041\Symfony\Component\DependencyInjection\Extension\Extension;
use _PhpScoper88fe6e0ad041\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
final class MarkdownDiffExtension extends \_PhpScoper88fe6e0ad041\Symfony\Component\DependencyInjection\Extension\Extension
{
    public function load(array $configs, \_PhpScoper88fe6e0ad041\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $phpFileLoader = new \_PhpScoper88fe6e0ad041\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \_PhpScoper88fe6e0ad041\Symfony\Component\Config\FileLocator(__DIR__ . '/../../../config'));
        $phpFileLoader->load('config.php');
    }
}
