<?php

declare (strict_types=1);
namespace Symplify\MarkdownDiff\Tests\HttpKernel;

use _PhpScoper006a73f0e455\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symplify\MarkdownDiff\Bundle\MarkdownDiffBundle;
use Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle;
use Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class MarkdownDiffKernel extends \Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    /**
     * @return BundleInterface[]
     */
    public function registerBundles() : iterable
    {
        return [new \Symplify\MarkdownDiff\Bundle\MarkdownDiffBundle(), new \Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle()];
    }
}
