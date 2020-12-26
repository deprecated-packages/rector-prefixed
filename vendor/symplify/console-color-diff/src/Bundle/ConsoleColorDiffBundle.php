<?php

declare (strict_types=1);
namespace Symplify\ConsoleColorDiff\Bundle;

use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use RectorPrefix2020DecSat\Symfony\Component\HttpKernel\Bundle\Bundle;
use Symplify\ConsoleColorDiff\DependencyInjection\Extension\ConsoleColorDiffExtension;
final class ConsoleColorDiffBundle extends \RectorPrefix2020DecSat\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \Symplify\ConsoleColorDiff\DependencyInjection\Extension\ConsoleColorDiffExtension();
    }
}
