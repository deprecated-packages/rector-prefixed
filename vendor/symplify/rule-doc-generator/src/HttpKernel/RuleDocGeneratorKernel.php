<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\HttpKernel;

use _PhpScoper2a4e7ab1ecbc\Symfony\Component\Config\Loader\LoaderInterface;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use _PhpScoper2a4e7ab1ecbc\Symplify\MarkdownDiff\Bundle\MarkdownDiffBundle;
use _PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle;
use _PhpScoper2a4e7ab1ecbc\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle;
use _PhpScoper2a4e7ab1ecbc\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class RuleDocGeneratorKernel extends \_PhpScoper2a4e7ab1ecbc\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    public function registerContainerConfiguration(\_PhpScoper2a4e7ab1ecbc\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
        parent::registerContainerConfiguration($loader);
    }
    /**
     * @return BundleInterface[]
     */
    public function registerBundles() : iterable
    {
        return [new \_PhpScoper2a4e7ab1ecbc\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle(), new \_PhpScoper2a4e7ab1ecbc\Symplify\MarkdownDiff\Bundle\MarkdownDiffBundle(), new \_PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle()];
    }
}
