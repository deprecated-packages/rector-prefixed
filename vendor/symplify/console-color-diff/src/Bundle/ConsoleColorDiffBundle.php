<?php

declare (strict_types=1);
namespace RectorPrefix20210414\Symplify\ConsoleColorDiff\Bundle;

use RectorPrefix20210414\Symfony\Component\HttpKernel\Bundle\Bundle;
use RectorPrefix20210414\Symplify\ConsoleColorDiff\DependencyInjection\Extension\ConsoleColorDiffExtension;
final class ConsoleColorDiffBundle extends \RectorPrefix20210414\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\RectorPrefix20210414\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \RectorPrefix20210414\Symplify\ConsoleColorDiff\DependencyInjection\Extension\ConsoleColorDiffExtension();
    }
}
