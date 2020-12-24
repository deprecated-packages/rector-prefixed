<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\DependencyInjection\Extension;

use _PhpScoperb75b35f52b74\Symfony\Component\Config\FileLocator;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Extension\Extension;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
final class PhpConfigPrinterExtension extends \_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Extension\Extension
{
    public function load(array $configs, \_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        // needed for parameter shifting of sniff/fixer params
        $phpFileLoader = new \_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \_PhpScoperb75b35f52b74\Symfony\Component\Config\FileLocator(__DIR__ . '/../../../config'));
        $phpFileLoader->load('config.php');
    }
}
