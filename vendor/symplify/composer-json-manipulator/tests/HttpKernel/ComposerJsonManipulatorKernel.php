<?php

declare (strict_types=1);
namespace RectorPrefix20210320\Symplify\ComposerJsonManipulator\Tests\HttpKernel;

use RectorPrefix20210320\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use RectorPrefix20210320\Symplify\ComposerJsonManipulator\Bundle\ComposerJsonManipulatorBundle;
use RectorPrefix20210320\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle;
use RectorPrefix20210320\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class ComposerJsonManipulatorKernel extends \RectorPrefix20210320\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    /**
     * @return BundleInterface[]
     */
    public function registerBundles() : array
    {
        return [new \RectorPrefix20210320\Symplify\ComposerJsonManipulator\Bundle\ComposerJsonManipulatorBundle(), new \RectorPrefix20210320\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle()];
    }
}
