<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Symplify\ComposerJsonManipulator\Bundle;

use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\HttpKernel\Bundle\Bundle;
use _PhpScoper2a4e7ab1ecbc\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension;
final class ComposerJsonManipulatorBundle extends \_PhpScoper2a4e7ab1ecbc\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension();
    }
}
