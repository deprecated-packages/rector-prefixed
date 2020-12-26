<?php

declare (strict_types=1);
namespace Symplify\Skipper\Bundle;

use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use RectorPrefix2020DecSat\Symfony\Component\HttpKernel\Bundle\Bundle;
use Symplify\Skipper\DependencyInjection\Extension\SkipperExtension;
final class SkipperBundle extends \RectorPrefix2020DecSat\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \Symplify\Skipper\DependencyInjection\Extension\SkipperExtension();
    }
}
