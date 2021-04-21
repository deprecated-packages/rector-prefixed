<?php

declare(strict_types=1);

namespace Symplify\SymplifyKernel\DependencyInjection\Extension;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

final class SymplifyKernelExtension extends Extension
{
    /**
     * @param string[] $configs
     * @return void
     */
    public function load(array $configs, ContainerBuilder $containerBuilder)
    {
        $phpFileLoader = new PhpFileLoader($containerBuilder, new FileLocator(__DIR__ . '/../../../config'));
        $phpFileLoader->load('common-config.php');
    }
}
