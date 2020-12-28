<?php

declare (strict_types=1);
namespace RectorPrefix20201228\Symplify\Skipper\Bundle;

use RectorPrefix20201228\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use RectorPrefix20201228\Symfony\Component\HttpKernel\Bundle\Bundle;
use RectorPrefix20201228\Symplify\Skipper\DependencyInjection\Extension\SkipperExtension;
final class SkipperBundle extends \RectorPrefix20201228\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\RectorPrefix20201228\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \RectorPrefix20201228\Symplify\Skipper\DependencyInjection\Extension\SkipperExtension();
    }
}
