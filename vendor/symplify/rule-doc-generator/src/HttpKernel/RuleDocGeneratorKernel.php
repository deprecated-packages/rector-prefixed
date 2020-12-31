<?php

declare (strict_types=1);
namespace Symplify\RuleDocGenerator\HttpKernel;

use RectorPrefix20201231\Symfony\Component\Config\Loader\LoaderInterface;
use RectorPrefix20201231\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use RectorPrefix20201231\Symplify\MarkdownDiff\Bundle\MarkdownDiffBundle;
use RectorPrefix20201231\Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle;
use RectorPrefix20201231\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle;
use RectorPrefix20201231\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class RuleDocGeneratorKernel extends \RectorPrefix20201231\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    public function registerContainerConfiguration(\RectorPrefix20201231\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
        parent::registerContainerConfiguration($loader);
    }
    /**
     * @return BundleInterface[]
     */
    public function registerBundles() : iterable
    {
        return [new \RectorPrefix20201231\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle(), new \RectorPrefix20201231\Symplify\MarkdownDiff\Bundle\MarkdownDiffBundle(), new \RectorPrefix20201231\Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle()];
    }
}
