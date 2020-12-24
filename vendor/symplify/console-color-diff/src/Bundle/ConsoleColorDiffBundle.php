<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Symplify\ConsoleColorDiff\Bundle;

use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use _PhpScoperb75b35f52b74\Symfony\Component\HttpKernel\Bundle\Bundle;
use _PhpScoperb75b35f52b74\Symplify\ConsoleColorDiff\DependencyInjection\Extension\ConsoleColorDiffExtension;
final class ConsoleColorDiffBundle extends \_PhpScoperb75b35f52b74\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \_PhpScoperb75b35f52b74\Symplify\ConsoleColorDiff\DependencyInjection\Extension\ConsoleColorDiffExtension();
    }
}
