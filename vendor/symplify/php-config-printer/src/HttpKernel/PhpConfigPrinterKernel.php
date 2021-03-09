<?php

declare (strict_types=1);
namespace RectorPrefix20210309\Symplify\PhpConfigPrinter\HttpKernel;

use RectorPrefix20210309\Symfony\Component\Config\Loader\LoaderInterface;
use RectorPrefix20210309\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use RectorPrefix20210309\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface;
use RectorPrefix20210309\Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle;
use RectorPrefix20210309\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class PhpConfigPrinterKernel extends \RectorPrefix20210309\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel implements \RectorPrefix20210309\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface
{
    /**
     * @var string[]
     */
    private $configs = [];
    public function registerContainerConfiguration(\RectorPrefix20210309\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
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
        return [new \RectorPrefix20210309\Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle()];
    }
    /**
     * @param string[] $configs
     */
    public function setConfigs(array $configs) : void
    {
        $this->configs = $configs;
    }
}
