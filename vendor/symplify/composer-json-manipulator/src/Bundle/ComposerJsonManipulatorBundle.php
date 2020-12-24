<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Symplify\ComposerJsonManipulator\Bundle;

use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use _PhpScoperb75b35f52b74\Symfony\Component\HttpKernel\Bundle\Bundle;
use _PhpScoperb75b35f52b74\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension;
final class ComposerJsonManipulatorBundle extends \_PhpScoperb75b35f52b74\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \_PhpScoperb75b35f52b74\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension();
    }
}
