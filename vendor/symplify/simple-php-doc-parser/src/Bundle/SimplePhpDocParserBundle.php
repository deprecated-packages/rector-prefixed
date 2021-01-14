<?php

declare (strict_types=1);
namespace RectorPrefix20210114\Symplify\SimplePhpDocParser\Bundle;

use RectorPrefix20210114\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use RectorPrefix20210114\Symfony\Component\HttpKernel\Bundle\Bundle;
use RectorPrefix20210114\Symplify\SimplePhpDocParser\Bundle\DependencyInjection\Extension\SimplePhpDocParserExtension;
final class SimplePhpDocParserBundle extends \RectorPrefix20210114\Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function getContainerExtension() : ?\RectorPrefix20210114\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \RectorPrefix20210114\Symplify\SimplePhpDocParser\Bundle\DependencyInjection\Extension\SimplePhpDocParserExtension();
    }
}
