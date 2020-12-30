<?php

declare (strict_types=1);
namespace RectorPrefix20201230\Symplify\SimplePhpDocParser\Bundle;

use RectorPrefix20201230\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use RectorPrefix20201230\Symfony\Component\HttpKernel\Bundle\Bundle;
use RectorPrefix20201230\Symplify\SimplePhpDocParser\Bundle\DependencyInjection\Extension\SimplePhpDocParserExtension;
final class SimplePhpDocParserBundle extends \RectorPrefix20201230\Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function getContainerExtension() : ?\RectorPrefix20201230\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \RectorPrefix20201230\Symplify\SimplePhpDocParser\Bundle\DependencyInjection\Extension\SimplePhpDocParserExtension();
    }
}
