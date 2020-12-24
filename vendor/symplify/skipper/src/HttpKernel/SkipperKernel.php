<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Symplify\Skipper\HttpKernel;

use _PhpScoperb75b35f52b74\Symfony\Component\Config\Loader\LoaderInterface;
use _PhpScoperb75b35f52b74\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use _PhpScoperb75b35f52b74\Symplify\Skipper\Bundle\SkipperBundle;
use _PhpScoperb75b35f52b74\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle;
use _PhpScoperb75b35f52b74\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class SkipperKernel extends \_PhpScoperb75b35f52b74\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    public function registerContainerConfiguration(\_PhpScoperb75b35f52b74\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
        parent::registerContainerConfiguration($loader);
    }
    /**
     * @return BundleInterface[]
     */
    public function registerBundles() : iterable
    {
        return [new \_PhpScoperb75b35f52b74\Symplify\Skipper\Bundle\SkipperBundle(), new \_PhpScoperb75b35f52b74\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle()];
    }
}
