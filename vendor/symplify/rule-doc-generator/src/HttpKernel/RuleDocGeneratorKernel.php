<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\HttpKernel;

use _PhpScoper0a2ac50786fa\Symfony\Component\Config\Loader\LoaderInterface;
use _PhpScoper0a2ac50786fa\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use _PhpScoper0a2ac50786fa\Symplify\MarkdownDiff\Bundle\MarkdownDiffBundle;
use _PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle;
use _PhpScoper0a2ac50786fa\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle;
use _PhpScoper0a2ac50786fa\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class RuleDocGeneratorKernel extends \_PhpScoper0a2ac50786fa\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
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
        return [new \_PhpScoper0a2ac50786fa\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle(), new \_PhpScoper0a2ac50786fa\Symplify\MarkdownDiff\Bundle\MarkdownDiffBundle(), new \_PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle()];
    }
}
