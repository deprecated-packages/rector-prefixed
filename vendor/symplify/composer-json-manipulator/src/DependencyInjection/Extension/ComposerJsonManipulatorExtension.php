<?php

declare (strict_types=1);
namespace Symplify\ComposerJsonManipulator\DependencyInjection\Extension;

use _PhpScoperfce0de0de1ce\Symfony\Component\Config\FileLocator;
use _PhpScoperfce0de0de1ce\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoperfce0de0de1ce\Symfony\Component\DependencyInjection\Extension\Extension;
use _PhpScoperfce0de0de1ce\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
final class ComposerJsonManipulatorExtension extends \_PhpScoperfce0de0de1ce\Symfony\Component\DependencyInjection\Extension\Extension
{
    public function load(array $configs, \_PhpScoperfce0de0de1ce\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $phpFileLoader = new \_PhpScoperfce0de0de1ce\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \_PhpScoperfce0de0de1ce\Symfony\Component\Config\FileLocator(__DIR__ . '/../../../config'));
        $phpFileLoader->load('config.php');
    }
}
