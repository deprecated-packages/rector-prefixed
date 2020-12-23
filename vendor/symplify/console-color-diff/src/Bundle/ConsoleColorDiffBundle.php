<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Symplify\ConsoleColorDiff\Bundle;

use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use _PhpScoper0a2ac50786fa\Symfony\Component\HttpKernel\Bundle\Bundle;
use _PhpScoper0a2ac50786fa\Symplify\ConsoleColorDiff\DependencyInjection\Extension\ConsoleColorDiffExtension;
final class ConsoleColorDiffBundle extends \_PhpScoper0a2ac50786fa\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\ConsoleColorDiff\DependencyInjection\Extension\ConsoleColorDiffExtension();
    }
}
