<?php

declare (strict_types=1);
namespace Symplify\ConsoleColorDiff;

use _PhpScoperabd03f0baf05\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use _PhpScoperabd03f0baf05\Symfony\Component\HttpKernel\Bundle\Bundle;
use Symplify\ConsoleColorDiff\DependencyInjection\Extension\ConsoleColorDiffExtension;
final class ConsoleColorDiffBundle extends \_PhpScoperabd03f0baf05\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\_PhpScoperabd03f0baf05\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \Symplify\ConsoleColorDiff\DependencyInjection\Extension\ConsoleColorDiffExtension();
    }
}
