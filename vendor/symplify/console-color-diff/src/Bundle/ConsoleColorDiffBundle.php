<?php

declare (strict_types=1);
namespace RectorPrefix20210312\Symplify\ConsoleColorDiff\Bundle;

use RectorPrefix20210312\Symfony\Component\HttpKernel\Bundle\Bundle;
use RectorPrefix20210312\Symplify\ConsoleColorDiff\DependencyInjection\Extension\ConsoleColorDiffExtension;
final class ConsoleColorDiffBundle extends \RectorPrefix20210312\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : \RectorPrefix20210312\Symplify\ConsoleColorDiff\DependencyInjection\Extension\ConsoleColorDiffExtension
    {
        return new \RectorPrefix20210312\Symplify\ConsoleColorDiff\DependencyInjection\Extension\ConsoleColorDiffExtension();
    }
}
