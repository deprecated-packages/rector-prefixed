<?php

declare (strict_types=1);
namespace Symplify\Skipper\HttpKernel;

use _PhpScoper267b3276efc2\Symfony\Component\Config\Loader\LoaderInterface;
use _PhpScoper267b3276efc2\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symplify\Skipper\Bundle\SkipperBundle;
use Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle;
use Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class SkipperKernel extends \Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    public function registerContainerConfiguration(\_PhpScoper267b3276efc2\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
        parent::registerContainerConfiguration($loader);
    }
    /**
     * @return BundleInterface[]
     */
    public function registerBundles() : iterable
    {
        return [new \Symplify\Skipper\Bundle\SkipperBundle(), new \Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle()];
    }
}
