<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\DependencyInjection\Extension;

use _PhpScoper0a2ac50786fa\Symfony\Component\Config\FileLocator;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Extension\Extension;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
final class PhpConfigPrinterExtension extends \_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Extension\Extension
{
    public function load(array $configs, \_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        // needed for parameter shifting of sniff/fixer params
        $phpFileLoader = new \_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \_PhpScoper0a2ac50786fa\Symfony\Component\Config\FileLocator(__DIR__ . '/../../../config'));
        $phpFileLoader->load('config.php');
    }
}
