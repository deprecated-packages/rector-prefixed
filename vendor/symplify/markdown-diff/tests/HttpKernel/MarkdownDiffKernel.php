<?php

declare (strict_types=1);
namespace RectorPrefix20210311\Symplify\MarkdownDiff\Tests\HttpKernel;

use RectorPrefix20210311\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use RectorPrefix20210311\Symplify\MarkdownDiff\Bundle\MarkdownDiffBundle;
use RectorPrefix20210311\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle;
use RectorPrefix20210311\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class MarkdownDiffKernel extends \RectorPrefix20210311\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    /**
     * @return BundleInterface[]
     */
    public function registerBundles() : iterable
    {
        return [new \RectorPrefix20210311\Symplify\MarkdownDiff\Bundle\MarkdownDiffBundle(), new \RectorPrefix20210311\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle()];
    }
}
