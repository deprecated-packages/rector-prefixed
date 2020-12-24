<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\HttpKernel;

use _PhpScoper0a6b37af0871\Symfony\Component\Config\Loader\LoaderInterface;
use _PhpScoper0a6b37af0871\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface;
use _PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle;
use _PhpScoper0a6b37af0871\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class PhpConfigPrinterKernel extends \_PhpScoper0a6b37af0871\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel implements \_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface
{
    /**
     * @var string[]
     */
    private $configs = [];
    public function registerContainerConfiguration(\_PhpScoper0a6b37af0871\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
        foreach ($this->configs as $config) {
            $loader->load($config);
        }
    }
    /**
     * @return BundleInterface[]
     */
    public function registerBundles() : iterable
    {
        return [new \_PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle()];
    }
    /**
     * @param string[] $configs
     */
    public function setConfigs(array $configs) : void
    {
        $this->configs = $configs;
    }
}
