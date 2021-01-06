<?php

declare (strict_types=1);
namespace RectorPrefix20210106\Symplify\Skipper\Bundle;

use RectorPrefix20210106\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use RectorPrefix20210106\Symfony\Component\HttpKernel\Bundle\Bundle;
use RectorPrefix20210106\Symplify\Skipper\DependencyInjection\Extension\SkipperExtension;
final class SkipperBundle extends \RectorPrefix20210106\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\RectorPrefix20210106\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \RectorPrefix20210106\Symplify\Skipper\DependencyInjection\Extension\SkipperExtension();
    }
}
