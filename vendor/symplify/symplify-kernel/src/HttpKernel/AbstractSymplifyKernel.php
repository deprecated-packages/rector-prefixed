<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Symplify\SymplifyKernel\HttpKernel;

use _PhpScoper0a6b37af0871\Symfony\Component\Config\Loader\LoaderInterface;
use _PhpScoper0a6b37af0871\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use _PhpScoper0a6b37af0871\Symfony\Component\HttpKernel\Kernel;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
use _PhpScoper0a6b37af0871\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle;
use _PhpScoper0a6b37af0871\Symplify\SymplifyKernel\Strings\KernelUniqueHasher;
abstract class AbstractSymplifyKernel extends \_PhpScoper0a6b37af0871\Symfony\Component\HttpKernel\Kernel implements \_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface
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
        return [new \_PhpScoper0a6b37af0871\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle()];
    }
    /**
     * @param string[]|SmartFileInfo[] $configs
     */
    public function setConfigs(array $configs) : void
    {
        foreach ($configs as $config) {
            if ($config instanceof \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo) {
                $config = $config->getRealPath();
            }
            $this->configs[] = $config;
        }
    }
    public function registerContainerConfiguration(\_PhpScoper0a6b37af0871\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        foreach ($this->configs as $config) {
            $loader->load($config);
        }
    }
    private function getUniqueKernelHash() : string
    {
        $kernelUniqueHasher = new \_PhpScoper0a6b37af0871\Symplify\SymplifyKernel\Strings\KernelUniqueHasher();
        return $kernelUniqueHasher->hashKernelClass(static::class);
    }
}
