<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\HttpKernel;

use _PhpScoper0a6b37af0871\Symfony\Component\Config\Loader\LoaderInterface;
use _PhpScoper0a6b37af0871\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use _PhpScoper0a6b37af0871\Symplify\MarkdownDiff\Bundle\MarkdownDiffBundle;
use _PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle;
use _PhpScoper0a6b37af0871\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle;
use _PhpScoper0a6b37af0871\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class RuleDocGeneratorKernel extends \_PhpScoper0a6b37af0871\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    public function registerContainerConfiguration(\_PhpScoper0a6b37af0871\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
        parent::registerContainerConfiguration($loader);
    }
    /**
     * @return BundleInterface[]
     */
    public function registerBundles() : iterable
    {
        return [new \_PhpScoper0a6b37af0871\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle(), new \_PhpScoper0a6b37af0871\Symplify\MarkdownDiff\Bundle\MarkdownDiffBundle(), new \_PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle()];
    }
}
