<?php

declare (strict_types=1);
namespace Symplify\Skipper\Bundle;

use _PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use _PhpScoperbf340cb0be9d\Symfony\Component\HttpKernel\Bundle\Bundle;
use Symplify\Skipper\DependencyInjection\Extension\SkipperExtension;
final class SkipperBundle extends \_PhpScoperbf340cb0be9d\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \Symplify\Skipper\DependencyInjection\Extension\SkipperExtension();
    }
}
