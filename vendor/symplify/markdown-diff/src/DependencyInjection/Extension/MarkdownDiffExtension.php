<?php

declare (strict_types=1);
namespace Symplify\MarkdownDiff\DependencyInjection\Extension;

use _PhpScoperabd03f0baf05\Symfony\Component\Config\FileLocator;
use _PhpScoperabd03f0baf05\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoperabd03f0baf05\Symfony\Component\DependencyInjection\Extension\Extension;
use _PhpScoperabd03f0baf05\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
final class MarkdownDiffExtension extends \_PhpScoperabd03f0baf05\Symfony\Component\DependencyInjection\Extension\Extension
{
    public function load(array $configs, \_PhpScoperabd03f0baf05\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $phpFileLoader = new \_PhpScoperabd03f0baf05\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \_PhpScoperabd03f0baf05\Symfony\Component\Config\FileLocator(__DIR__ . '/../../../config'));
        $phpFileLoader->load('config.php');
    }
}
