<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\SymplifyKernel\HttpKernel;

use _PhpScopere8e811afab72\Symfony\Component\Config\Loader\LoaderInterface;
use _PhpScopere8e811afab72\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use _PhpScopere8e811afab72\Symfony\Component\HttpKernel\Kernel;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
use _PhpScopere8e811afab72\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle;
use _PhpScopere8e811afab72\Symplify\SymplifyKernel\Strings\KernelUniqueHasher;
abstract class AbstractSymplifyKernel extends \_PhpScopere8e811afab72\Symfony\Component\HttpKernel\Kernel implements \_PhpScopere8e811afab72\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface
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
        return [new \_PhpScopere8e811afab72\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle()];
    }
    /**
     * @param string[]|SmartFileInfo[] $configs
     */
    public function setConfigs(array $configs) : void
    {
        foreach ($configs as $config) {
            if ($config instanceof \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo) {
                $config = $config->getRealPath();
            }
            $this->configs[] = $config;
        }
    }
    public function registerContainerConfiguration(\_PhpScopere8e811afab72\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        foreach ($this->configs as $config) {
            $loader->load($config);
        }
    }
    private function getUniqueKernelHash() : string
    {
        $kernelUniqueHasher = new \_PhpScopere8e811afab72\Symplify\SymplifyKernel\Strings\KernelUniqueHasher();
        return $kernelUniqueHasher->hashKernelClass(static::class);
    }
}
