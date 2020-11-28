<?php

declare (strict_types=1);
namespace Symplify\Skipper\Bundle;

use _PhpScoperabd03f0baf05\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use _PhpScoperabd03f0baf05\Symfony\Component\HttpKernel\Bundle\Bundle;
use Symplify\Skipper\DependencyInjection\Extension\SkipperExtension;
final class SkipperBundle extends \_PhpScoperabd03f0baf05\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\_PhpScoperabd03f0baf05\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \Symplify\Skipper\DependencyInjection\Extension\SkipperExtension();
    }
}
