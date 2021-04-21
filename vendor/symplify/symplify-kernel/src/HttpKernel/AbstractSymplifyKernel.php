<?php

declare (strict_types=1);
namespace RectorPrefix20210421\Symplify\SymplifyKernel\HttpKernel;

use RectorPrefix20210421\Symfony\Component\Config\Loader\LoaderInterface;
use RectorPrefix20210421\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use RectorPrefix20210421\Symfony\Component\HttpKernel\Kernel;
use RectorPrefix20210421\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface;
use RectorPrefix20210421\Symplify\SmartFileSystem\SmartFileInfo;
use RectorPrefix20210421\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle;
use RectorPrefix20210421\Symplify\SymplifyKernel\Strings\KernelUniqueHasher;
abstract class AbstractSymplifyKernel extends \RectorPrefix20210421\Symfony\Component\HttpKernel\Kernel implements \RectorPrefix20210421\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface
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
        return [new \RectorPrefix20210421\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle()];
    }
    /**
     * @param string[]|SmartFileInfo[] $configs
     * @return void
     */
    public function setConfigs(array $configs)
    {
        foreach ($configs as $config) {
            if ($config instanceof \RectorPrefix20210421\Symplify\SmartFileSystem\SmartFileInfo) {
                $config = $config->getRealPath();
            }
            $this->configs[] = $config;
        }
    }
    /**
     * @return void
     */
    public function registerContainerConfiguration(\RectorPrefix20210421\Symfony\Component\Config\Loader\LoaderInterface $loader)
    {
        foreach ($this->configs as $config) {
            $loader->load($config);
        }
    }
    private function getUniqueKernelHash() : string
    {
        $kernelUniqueHasher = new \RectorPrefix20210421\Symplify\SymplifyKernel\Strings\KernelUniqueHasher();
        return $kernelUniqueHasher->hashKernelClass(static::class);
    }
}
