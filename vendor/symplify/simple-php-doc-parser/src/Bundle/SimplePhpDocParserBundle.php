<?php

declare (strict_types=1);
namespace RectorPrefix20201231\Symplify\SimplePhpDocParser\Bundle;

use RectorPrefix20201231\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use RectorPrefix20201231\Symfony\Component\HttpKernel\Bundle\Bundle;
use RectorPrefix20201231\Symplify\SimplePhpDocParser\Bundle\DependencyInjection\Extension\SimplePhpDocParserExtension;
final class SimplePhpDocParserBundle extends \RectorPrefix20201231\Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function getContainerExtension() : ?\RectorPrefix20201231\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \RectorPrefix20201231\Symplify\SimplePhpDocParser\Bundle\DependencyInjection\Extension\SimplePhpDocParserExtension();
    }
}
