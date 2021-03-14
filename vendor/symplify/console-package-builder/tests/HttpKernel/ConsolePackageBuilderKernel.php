<?php

declare (strict_types=1);
namespace RectorPrefix20210314\Symplify\ConsolePackageBuilder\Tests\HttpKernel;

use RectorPrefix20210314\Symfony\Component\Config\Loader\LoaderInterface;
use RectorPrefix20210314\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use RectorPrefix20210314\Symfony\Component\HttpKernel\Kernel;
use RectorPrefix20210314\Symplify\ConsolePackageBuilder\Bundle\NamelessConsoleCommandBundle;
use RectorPrefix20210314\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface;
final class ConsolePackageBuilderKernel extends \RectorPrefix20210314\Symfony\Component\HttpKernel\Kernel implements \RectorPrefix20210314\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface
{
    /**
     * @var string[]
     */
    private $configs = [];
    /**
     * @return BundleInterface[]
     */
    public function registerBundles() : iterable
    {
        return [new \RectorPrefix20210314\Symplify\ConsolePackageBuilder\Bundle\NamelessConsoleCommandBundle()];
    }
    public function registerContainerConfiguration(\RectorPrefix20210314\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        foreach ($this->configs as $config) {
            $loader->load($config);
        }
    }
    /**
     * @param string[] $configs
     */
    public function setConfigs(array $configs) : void
    {
        $this->configs = $configs;
    }
    public function getCacheDir() : string
    {
        return \sys_get_temp_dir() . '/console_package_builder';
    }
    public function getLogDir() : string
    {
        return \sys_get_temp_dir() . '/console_package_builder_log';
    }
}