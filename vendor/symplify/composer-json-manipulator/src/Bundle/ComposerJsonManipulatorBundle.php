<?php

declare (strict_types=1);
namespace RectorPrefix20210206\Symplify\ComposerJsonManipulator\Bundle;

use RectorPrefix20210206\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use RectorPrefix20210206\Symfony\Component\HttpKernel\Bundle\Bundle;
use RectorPrefix20210206\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension;
final class ComposerJsonManipulatorBundle extends \RectorPrefix20210206\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\RectorPrefix20210206\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \RectorPrefix20210206\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension();
    }
}
