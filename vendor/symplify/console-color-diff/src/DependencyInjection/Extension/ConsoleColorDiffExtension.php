<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Symplify\ConsoleColorDiff\DependencyInjection\Extension;

use _PhpScoper0a6b37af0871\Symfony\Component\Config\FileLocator;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Extension\Extension;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
final class ConsoleColorDiffExtension extends \_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Extension\Extension
{
    public function load(array $configs, \_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $phpFileLoader = new \_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \_PhpScoper0a6b37af0871\Symfony\Component\Config\FileLocator(__DIR__ . '/../../../config'));
        $phpFileLoader->load('config.php');
    }
}
