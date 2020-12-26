<?php

declare (strict_types=1);
namespace Symplify\ComposerJsonManipulator\Bundle;

use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use RectorPrefix2020DecSat\Symfony\Component\HttpKernel\Bundle\Bundle;
use Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension;
final class ComposerJsonManipulatorBundle extends \RectorPrefix2020DecSat\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension();
    }
}
