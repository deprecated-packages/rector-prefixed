<?php

declare (strict_types=1);
namespace Symplify\ConsoleColorDiff\DependencyInjection\Extension;

use _PhpScoperbf340cb0be9d\Symfony\Component\Config\FileLocator;
use _PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Extension\Extension;
use _PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
final class ConsoleColorDiffExtension extends \_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Extension\Extension
{
    public function load(array $configs, \_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $phpFileLoader = new \_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \_PhpScoperbf340cb0be9d\Symfony\Component\Config\FileLocator(__DIR__ . '/../../../config'));
        $phpFileLoader->load('config.php');
    }
}
