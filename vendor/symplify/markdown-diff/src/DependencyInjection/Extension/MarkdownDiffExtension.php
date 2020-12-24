<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Symplify\MarkdownDiff\DependencyInjection\Extension;

use _PhpScoper2a4e7ab1ecbc\Symfony\Component\Config\FileLocator;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Extension\Extension;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
final class MarkdownDiffExtension extends \_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Extension\Extension
{
    public function load(array $configs, \_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $phpFileLoader = new \_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \_PhpScoper2a4e7ab1ecbc\Symfony\Component\Config\FileLocator(__DIR__ . '/../../../config'));
        $phpFileLoader->load('config.php');
    }
}
