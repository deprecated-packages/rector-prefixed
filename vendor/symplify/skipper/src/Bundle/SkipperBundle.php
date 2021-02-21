<?php

declare (strict_types=1);
namespace RectorPrefix20210221\Symplify\Skipper\Bundle;

use RectorPrefix20210221\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use RectorPrefix20210221\Symfony\Component\HttpKernel\Bundle\Bundle;
use RectorPrefix20210221\Symplify\Skipper\DependencyInjection\Extension\SkipperExtension;
final class SkipperBundle extends \RectorPrefix20210221\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\RectorPrefix20210221\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \RectorPrefix20210221\Symplify\Skipper\DependencyInjection\Extension\SkipperExtension();
    }
}
