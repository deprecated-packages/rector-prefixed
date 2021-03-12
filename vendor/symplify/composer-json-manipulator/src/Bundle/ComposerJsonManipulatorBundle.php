<?php

declare (strict_types=1);
namespace RectorPrefix20210312\Symplify\ComposerJsonManipulator\Bundle;

use RectorPrefix20210312\Symfony\Component\HttpKernel\Bundle\Bundle;
use RectorPrefix20210312\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension;
final class ComposerJsonManipulatorBundle extends \RectorPrefix20210312\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : \RectorPrefix20210312\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension
    {
        return new \RectorPrefix20210312\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension();
    }
}
