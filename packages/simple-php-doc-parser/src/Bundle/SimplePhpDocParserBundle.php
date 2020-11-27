<?php

declare (strict_types=1);
namespace Rector\SimplePhpDocParser\Bundle;

use Rector\SimplePhpDocParser\Bundle\DependencyInjection\Extension\SimplePhpDocParserExtension;
use _PhpScoper006a73f0e455\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use _PhpScoper006a73f0e455\Symfony\Component\HttpKernel\Bundle\Bundle;
final class SimplePhpDocParserBundle extends \_PhpScoper006a73f0e455\Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function getContainerExtension() : ?\_PhpScoper006a73f0e455\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \Rector\SimplePhpDocParser\Bundle\DependencyInjection\Extension\SimplePhpDocParserExtension();
    }
}
