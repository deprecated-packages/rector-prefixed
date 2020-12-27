<?php

declare (strict_types=1);
namespace RectorPrefix20201227\Symplify\RuleDocGenerator\HttpKernel;

use RectorPrefix20201227\Symfony\Component\Config\Loader\LoaderInterface;
use RectorPrefix20201227\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use RectorPrefix20201227\Symplify\MarkdownDiff\Bundle\MarkdownDiffBundle;
use RectorPrefix20201227\Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle;
use RectorPrefix20201227\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle;
use RectorPrefix20201227\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class RuleDocGeneratorKernel extends \RectorPrefix20201227\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    public function registerContainerConfiguration(\RectorPrefix20201227\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
        parent::registerContainerConfiguration($loader);
    }
    /**
     * @return BundleInterface[]
     */
    public function registerBundles() : iterable
    {
        return [new \RectorPrefix20201227\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle(), new \RectorPrefix20201227\Symplify\MarkdownDiff\Bundle\MarkdownDiffBundle(), new \RectorPrefix20201227\Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle()];
    }
}
