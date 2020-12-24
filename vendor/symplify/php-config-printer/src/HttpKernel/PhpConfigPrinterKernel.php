<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\HttpKernel;

use _PhpScoper2a4e7ab1ecbc\Symfony\Component\Config\Loader\LoaderInterface;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use _PhpScoper2a4e7ab1ecbc\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface;
use _PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle;
use _PhpScoper2a4e7ab1ecbc\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class PhpConfigPrinterKernel extends \_PhpScoper2a4e7ab1ecbc\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel implements \_PhpScoper2a4e7ab1ecbc\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface
{
    /**
     * @var string[]
     */
    private $configs = [];
    public function registerContainerConfiguration(\_PhpScoper2a4e7ab1ecbc\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
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
        return [new \_PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle()];
    }
    /**
     * @param string[] $configs
     */
    public function setConfigs(array $configs) : void
    {
        $this->configs = $configs;
    }
}
