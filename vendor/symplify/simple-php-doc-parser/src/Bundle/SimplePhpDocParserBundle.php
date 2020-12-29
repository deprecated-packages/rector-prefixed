<?php

declare (strict_types=1);
namespace RectorPrefix20201229\Symplify\SimplePhpDocParser\Bundle;

use RectorPrefix20201229\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use RectorPrefix20201229\Symfony\Component\HttpKernel\Bundle\Bundle;
use RectorPrefix20201229\Symplify\SimplePhpDocParser\Bundle\DependencyInjection\Extension\SimplePhpDocParserExtension;
final class SimplePhpDocParserBundle extends \RectorPrefix20201229\Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function getContainerExtension() : ?\RectorPrefix20201229\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \RectorPrefix20201229\Symplify\SimplePhpDocParser\Bundle\DependencyInjection\Extension\SimplePhpDocParserExtension();
    }
}
