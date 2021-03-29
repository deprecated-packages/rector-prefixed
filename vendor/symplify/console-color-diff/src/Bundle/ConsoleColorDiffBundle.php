<?php

declare (strict_types=1);
namespace RectorPrefix20210329\Symplify\ConsoleColorDiff\Bundle;

use RectorPrefix20210329\Symfony\Component\HttpKernel\Bundle\Bundle;
use RectorPrefix20210329\Symplify\ConsoleColorDiff\DependencyInjection\Extension\ConsoleColorDiffExtension;
final class ConsoleColorDiffBundle extends \RectorPrefix20210329\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\RectorPrefix20210329\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \RectorPrefix20210329\Symplify\ConsoleColorDiff\DependencyInjection\Extension\ConsoleColorDiffExtension();
    }
}
