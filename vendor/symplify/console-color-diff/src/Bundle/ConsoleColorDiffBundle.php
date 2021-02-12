<?php

declare (strict_types=1);
namespace RectorPrefix20210212\Symplify\ConsoleColorDiff\Bundle;

use RectorPrefix20210212\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use RectorPrefix20210212\Symfony\Component\HttpKernel\Bundle\Bundle;
use RectorPrefix20210212\Symplify\ConsoleColorDiff\DependencyInjection\Extension\ConsoleColorDiffExtension;
final class ConsoleColorDiffBundle extends \RectorPrefix20210212\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\RectorPrefix20210212\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \RectorPrefix20210212\Symplify\ConsoleColorDiff\DependencyInjection\Extension\ConsoleColorDiffExtension();
    }
}
