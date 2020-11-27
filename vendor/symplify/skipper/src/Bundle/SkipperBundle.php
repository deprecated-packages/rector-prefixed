<?php

declare (strict_types=1);
namespace Symplify\Skipper\Bundle;

use _PhpScoperbd5d0c5f7638\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use _PhpScoperbd5d0c5f7638\Symfony\Component\HttpKernel\Bundle\Bundle;
use Symplify\Skipper\DependencyInjection\Extension\SkipperExtension;
final class SkipperBundle extends \_PhpScoperbd5d0c5f7638\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\_PhpScoperbd5d0c5f7638\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \Symplify\Skipper\DependencyInjection\Extension\SkipperExtension();
    }
}
