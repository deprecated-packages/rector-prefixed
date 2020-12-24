<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\Skipper\HttpKernel;

use _PhpScopere8e811afab72\Symfony\Component\Config\Loader\LoaderInterface;
use _PhpScopere8e811afab72\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use _PhpScopere8e811afab72\Symplify\Skipper\Bundle\SkipperBundle;
use _PhpScopere8e811afab72\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle;
use _PhpScopere8e811afab72\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class SkipperKernel extends \_PhpScopere8e811afab72\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    public function registerContainerConfiguration(\_PhpScopere8e811afab72\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
        parent::registerContainerConfiguration($loader);
    }
    /**
     * @return BundleInterface[]
     */
    public function registerBundles() : iterable
    {
        return [new \_PhpScopere8e811afab72\Symplify\Skipper\Bundle\SkipperBundle(), new \_PhpScopere8e811afab72\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle()];
    }
}
