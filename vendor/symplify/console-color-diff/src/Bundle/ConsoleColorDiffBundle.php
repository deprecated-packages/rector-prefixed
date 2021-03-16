<?php

declare (strict_types=1);
namespace RectorPrefix20210316\Symplify\ConsoleColorDiff\Bundle;

use RectorPrefix20210316\Symfony\Component\HttpKernel\Bundle\Bundle;
use RectorPrefix20210316\Symplify\ConsoleColorDiff\DependencyInjection\Extension\ConsoleColorDiffExtension;
final class ConsoleColorDiffBundle extends \RectorPrefix20210316\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : \RectorPrefix20210316\Symplify\ConsoleColorDiff\DependencyInjection\Extension\ConsoleColorDiffExtension
    {
        return new \RectorPrefix20210316\Symplify\ConsoleColorDiff\DependencyInjection\Extension\ConsoleColorDiffExtension();
    }
}
