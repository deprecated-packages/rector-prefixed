<?php

declare (strict_types=1);
namespace RectorPrefix20201231\Symplify\ConsoleColorDiff\Bundle;

use RectorPrefix20201231\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use RectorPrefix20201231\Symfony\Component\HttpKernel\Bundle\Bundle;
use RectorPrefix20201231\Symplify\ConsoleColorDiff\DependencyInjection\Extension\ConsoleColorDiffExtension;
final class ConsoleColorDiffBundle extends \RectorPrefix20201231\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\RectorPrefix20201231\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \RectorPrefix20201231\Symplify\ConsoleColorDiff\DependencyInjection\Extension\ConsoleColorDiffExtension();
    }
}
