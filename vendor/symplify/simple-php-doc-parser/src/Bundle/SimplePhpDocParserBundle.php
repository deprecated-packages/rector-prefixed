<?php

declare (strict_types=1);
namespace Symplify\SimplePhpDocParser\Bundle;

use _PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use _PhpScoperbf340cb0be9d\Symfony\Component\HttpKernel\Bundle\Bundle;
use Symplify\SimplePhpDocParser\Bundle\DependencyInjection\Extension\SimplePhpDocParserExtension;
final class SimplePhpDocParserBundle extends \_PhpScoperbf340cb0be9d\Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function getContainerExtension() : ?\_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \Symplify\SimplePhpDocParser\Bundle\DependencyInjection\Extension\SimplePhpDocParserExtension();
    }
}
