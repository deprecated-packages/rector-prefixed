<?php

declare (strict_types=1);
namespace RectorPrefix20210323\Symplify\ConsoleColorDiff\Bundle;

use RectorPrefix20210323\Symfony\Component\HttpKernel\Bundle\Bundle;
use RectorPrefix20210323\Symplify\ConsoleColorDiff\DependencyInjection\Extension\ConsoleColorDiffExtension;
final class ConsoleColorDiffBundle extends \RectorPrefix20210323\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\RectorPrefix20210323\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \RectorPrefix20210323\Symplify\ConsoleColorDiff\DependencyInjection\Extension\ConsoleColorDiffExtension();
    }
}
