<?php

declare (strict_types=1);
namespace RectorPrefix20210420\Symplify\Skipper\Bundle;

use RectorPrefix20210420\Symfony\Component\HttpKernel\Bundle\Bundle;
use RectorPrefix20210420\Symplify\Skipper\DependencyInjection\Extension\SkipperExtension;
final class SkipperBundle extends \RectorPrefix20210420\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\RectorPrefix20210420\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \RectorPrefix20210420\Symplify\Skipper\DependencyInjection\Extension\SkipperExtension();
    }
}
