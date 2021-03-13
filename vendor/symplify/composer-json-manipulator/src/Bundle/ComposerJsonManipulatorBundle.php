<?php

declare (strict_types=1);
namespace RectorPrefix20210313\Symplify\ComposerJsonManipulator\Bundle;

use RectorPrefix20210313\Symfony\Component\HttpKernel\Bundle\Bundle;
use RectorPrefix20210313\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension;
final class ComposerJsonManipulatorBundle extends \RectorPrefix20210313\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : \RectorPrefix20210313\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension
    {
        return new \RectorPrefix20210313\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension();
    }
}
