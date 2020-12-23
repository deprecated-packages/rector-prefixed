<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Symplify\Skipper\HttpKernel;

use _PhpScoper0a2ac50786fa\Symfony\Component\Config\Loader\LoaderInterface;
use _PhpScoper0a2ac50786fa\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use _PhpScoper0a2ac50786fa\Symplify\Skipper\Bundle\SkipperBundle;
use _PhpScoper0a2ac50786fa\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle;
use _PhpScoper0a2ac50786fa\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class SkipperKernel extends \_PhpScoper0a2ac50786fa\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    public function registerContainerConfiguration(\_PhpScoper0a2ac50786fa\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
        parent::registerContainerConfiguration($loader);
    }
    /**
     * @return BundleInterface[]
     */
    public function registerBundles() : iterable
    {
        return [new \_PhpScoper0a2ac50786fa\Symplify\Skipper\Bundle\SkipperBundle(), new \_PhpScoper0a2ac50786fa\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle()];
    }
}
