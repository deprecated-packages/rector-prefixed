<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Symplify\SimplePhpDocParser\Bundle;

use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use _PhpScoper0a2ac50786fa\Symfony\Component\HttpKernel\Bundle\Bundle;
use _PhpScoper0a2ac50786fa\Symplify\SimplePhpDocParser\Bundle\DependencyInjection\Extension\SimplePhpDocParserExtension;
final class SimplePhpDocParserBundle extends \_PhpScoper0a2ac50786fa\Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function getContainerExtension() : ?\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\SimplePhpDocParser\Bundle\DependencyInjection\Extension\SimplePhpDocParserExtension();
    }
}
