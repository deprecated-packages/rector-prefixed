<?php

declare (strict_types=1);
namespace RectorPrefix20210316\Symplify\Skipper\Bundle;

use RectorPrefix20210316\Symfony\Component\HttpKernel\Bundle\Bundle;
use RectorPrefix20210316\Symplify\Skipper\DependencyInjection\Extension\SkipperExtension;
final class SkipperBundle extends \RectorPrefix20210316\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : \RectorPrefix20210316\Symplify\Skipper\DependencyInjection\Extension\SkipperExtension
    {
        return new \RectorPrefix20210316\Symplify\Skipper\DependencyInjection\Extension\SkipperExtension();
    }
}
