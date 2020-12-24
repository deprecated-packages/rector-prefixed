<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Symplify\SimplePhpDocParser\Bundle;

use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\HttpKernel\Bundle\Bundle;
use _PhpScoper2a4e7ab1ecbc\Symplify\SimplePhpDocParser\Bundle\DependencyInjection\Extension\SimplePhpDocParserExtension;
final class SimplePhpDocParserBundle extends \_PhpScoper2a4e7ab1ecbc\Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function getContainerExtension() : ?\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\SimplePhpDocParser\Bundle\DependencyInjection\Extension\SimplePhpDocParserExtension();
    }
}
