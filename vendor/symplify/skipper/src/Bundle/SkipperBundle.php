<?php

declare (strict_types=1);
namespace Symplify\Skipper\Bundle;

use RectorPrefix20201226\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use RectorPrefix20201226\Symfony\Component\HttpKernel\Bundle\Bundle;
use Symplify\Skipper\DependencyInjection\Extension\SkipperExtension;
final class SkipperBundle extends \RectorPrefix20201226\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\RectorPrefix20201226\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \Symplify\Skipper\DependencyInjection\Extension\SkipperExtension();
    }
}
