<?php

declare (strict_types=1);
namespace RectorPrefix20210404\Symplify\ComposerJsonManipulator\Bundle;

use RectorPrefix20210404\Symfony\Component\HttpKernel\Bundle\Bundle;
use RectorPrefix20210404\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension;
final class ComposerJsonManipulatorBundle extends \RectorPrefix20210404\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\RectorPrefix20210404\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \RectorPrefix20210404\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension();
    }
}
