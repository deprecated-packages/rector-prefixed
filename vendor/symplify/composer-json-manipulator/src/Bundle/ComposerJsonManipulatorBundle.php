<?php

declare (strict_types=1);
namespace Symplify\ComposerJsonManipulator\Bundle;

use _PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use _PhpScoperbf340cb0be9d\Symfony\Component\HttpKernel\Bundle\Bundle;
use Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension;
final class ComposerJsonManipulatorBundle extends \_PhpScoperbf340cb0be9d\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension();
    }
}
