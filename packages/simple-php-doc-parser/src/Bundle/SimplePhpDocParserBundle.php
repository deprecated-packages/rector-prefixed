<?php

declare (strict_types=1);
namespace Rector\SimplePhpDocParser\Bundle;

use Rector\SimplePhpDocParser\Bundle\DependencyInjection\Extension\SimplePhpDocParserExtension;
use _PhpScoperbd5d0c5f7638\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use _PhpScoperbd5d0c5f7638\Symfony\Component\HttpKernel\Bundle\Bundle;
final class SimplePhpDocParserBundle extends \_PhpScoperbd5d0c5f7638\Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function getContainerExtension() : ?\_PhpScoperbd5d0c5f7638\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \Rector\SimplePhpDocParser\Bundle\DependencyInjection\Extension\SimplePhpDocParserExtension();
    }
}
