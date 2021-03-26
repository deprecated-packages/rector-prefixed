<?php

declare (strict_types=1);
namespace RectorPrefix20210326\Symplify\ConsoleColorDiff\Bundle;

use RectorPrefix20210326\Symfony\Component\HttpKernel\Bundle\Bundle;
use RectorPrefix20210326\Symplify\ConsoleColorDiff\DependencyInjection\Extension\ConsoleColorDiffExtension;
final class ConsoleColorDiffBundle extends \RectorPrefix20210326\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\RectorPrefix20210326\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \RectorPrefix20210326\Symplify\ConsoleColorDiff\DependencyInjection\Extension\ConsoleColorDiffExtension();
    }
}
