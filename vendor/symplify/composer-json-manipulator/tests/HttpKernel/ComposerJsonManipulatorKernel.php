<?php

declare (strict_types=1);
namespace RectorPrefix20210407\Symplify\ComposerJsonManipulator\Tests\HttpKernel;

use RectorPrefix20210407\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use RectorPrefix20210407\Symplify\ComposerJsonManipulator\Bundle\ComposerJsonManipulatorBundle;
use RectorPrefix20210407\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle;
use RectorPrefix20210407\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class ComposerJsonManipulatorKernel extends \RectorPrefix20210407\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    /**
     * @return BundleInterface[]
     */
    public function registerBundles() : array
    {
        return [new \RectorPrefix20210407\Symplify\ComposerJsonManipulator\Bundle\ComposerJsonManipulatorBundle(), new \RectorPrefix20210407\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle()];
    }
}
