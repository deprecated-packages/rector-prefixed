<?php

declare (strict_types=1);
namespace Symplify\SymplifyKernel\HttpKernel;

use _PhpScoper17db12703726\Symfony\Component\Config\Loader\LoaderInterface;
use _PhpScoper17db12703726\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use _PhpScoper17db12703726\Symfony\Component\HttpKernel\Kernel;
use Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface;
use Symplify\SmartFileSystem\SmartFileInfo;
use Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle;
use Symplify\SymplifyKernel\Strings\KernelUniqueHasher;
abstract class AbstractSymplifyKernel extends \_PhpScoper17db12703726\Symfony\Component\HttpKernel\Kernel implements \Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface
{
    /**
     * @var string[]
     */
    private $configs = [];
    public function getCacheDir() : string
    {
        return \sys_get_temp_dir() . '/' . $this->getUniqueKernelHash();
    }
    public function getLogDir() : string
    {
        return \sys_get_temp_dir() . '/' . $this->getUniqueKernelHash() . '_log';
    }
    /**
     * @return BundleInterface[]
     */
    public function registerBundles() : iterable
    {
        return [new \Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle()];
    }
    /**
     * @param string[]|SmartFileInfo[] $configs
     */
    public function setConfigs(array $configs) : void
    {
        foreach ($configs as $config) {
            if ($config instanceof \Symplify\SmartFileSystem\SmartFileInfo) {
                $config = $config->getRealPath();
            }
            $this->configs[] = $config;
        }
    }
    public function registerContainerConfiguration(\_PhpScoper17db12703726\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        foreach ($this->configs as $config) {
            $loader->load($config);
        }
    }
    private function getUniqueKernelHash() : string
    {
        $kernelUniqueHasher = new \Symplify\SymplifyKernel\Strings\KernelUniqueHasher();
        return $kernelUniqueHasher->hashKernelClass(static::class);
    }
}
