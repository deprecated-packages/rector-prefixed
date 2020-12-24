<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\MarkdownDiff\DependencyInjection\Extension;

use _PhpScopere8e811afab72\Symfony\Component\Config\FileLocator;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Extension\Extension;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
final class MarkdownDiffExtension extends \_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Extension\Extension
{
    public function load(array $configs, \_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $phpFileLoader = new \_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \_PhpScopere8e811afab72\Symfony\Component\Config\FileLocator(__DIR__ . '/../../../config'));
        $phpFileLoader->load('config.php');
    }
}
