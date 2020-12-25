<?php

declare (strict_types=1);
namespace Symplify\SimplePhpDocParser\Bundle;

use _PhpScoper5edc98a7cce2\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use _PhpScoper5edc98a7cce2\Symfony\Component\HttpKernel\Bundle\Bundle;
use Symplify\SimplePhpDocParser\Bundle\DependencyInjection\Extension\SimplePhpDocParserExtension;
final class SimplePhpDocParserBundle extends \_PhpScoper5edc98a7cce2\Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function getContainerExtension() : ?\_PhpScoper5edc98a7cce2\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \Symplify\SimplePhpDocParser\Bundle\DependencyInjection\Extension\SimplePhpDocParserExtension();
    }
}
