<?php

declare (strict_types=1);
namespace Symplify\SimplePhpDocParser\Bundle;

use _PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use _PhpScoper8b9c402c5f32\Symfony\Component\HttpKernel\Bundle\Bundle;
use Symplify\SimplePhpDocParser\Bundle\DependencyInjection\Extension\SimplePhpDocParserExtension;
final class SimplePhpDocParserBundle extends \_PhpScoper8b9c402c5f32\Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function getContainerExtension() : ?\_PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \Symplify\SimplePhpDocParser\Bundle\DependencyInjection\Extension\SimplePhpDocParserExtension();
    }
}
