<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Symplify\ComposerJsonManipulator\Bundle;

use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use _PhpScoper0a6b37af0871\Symfony\Component\HttpKernel\Bundle\Bundle;
use _PhpScoper0a6b37af0871\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension;
final class ComposerJsonManipulatorBundle extends \_PhpScoper0a6b37af0871\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \_PhpScoper0a6b37af0871\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension();
    }
}
