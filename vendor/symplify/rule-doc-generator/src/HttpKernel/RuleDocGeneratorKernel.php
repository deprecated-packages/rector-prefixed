<?php

declare (strict_types=1);
namespace Symplify\RuleDocGenerator\HttpKernel;

use RectorPrefix20210216\Symfony\Component\Config\Loader\LoaderInterface;
use RectorPrefix20210216\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use RectorPrefix20210216\Symplify\MarkdownDiff\Bundle\MarkdownDiffBundle;
use RectorPrefix20210216\Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle;
use RectorPrefix20210216\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle;
use RectorPrefix20210216\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class RuleDocGeneratorKernel extends \RectorPrefix20210216\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    public function registerContainerConfiguration(\RectorPrefix20210216\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
        parent::registerContainerConfiguration($loader);
    }
    /**
     * @return BundleInterface[]
     */
    public function registerBundles() : iterable
    {
        return [new \RectorPrefix20210216\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle(), new \RectorPrefix20210216\Symplify\MarkdownDiff\Bundle\MarkdownDiffBundle(), new \RectorPrefix20210216\Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle()];
    }
}
