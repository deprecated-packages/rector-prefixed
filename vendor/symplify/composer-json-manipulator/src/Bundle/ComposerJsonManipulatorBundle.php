<?php

declare (strict_types=1);
namespace RectorPrefix20210228\Symplify\ComposerJsonManipulator\Bundle;

use RectorPrefix20210228\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use RectorPrefix20210228\Symfony\Component\HttpKernel\Bundle\Bundle;
use RectorPrefix20210228\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension;
final class ComposerJsonManipulatorBundle extends \RectorPrefix20210228\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\RectorPrefix20210228\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \RectorPrefix20210228\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension();
    }
}
