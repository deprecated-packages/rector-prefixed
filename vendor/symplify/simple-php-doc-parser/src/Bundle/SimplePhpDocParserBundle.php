<?php

declare (strict_types=1);
namespace Symplify\SimplePhpDocParser\Bundle;

use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use RectorPrefix2020DecSat\Symfony\Component\HttpKernel\Bundle\Bundle;
use Symplify\SimplePhpDocParser\Bundle\DependencyInjection\Extension\SimplePhpDocParserExtension;
final class SimplePhpDocParserBundle extends \RectorPrefix2020DecSat\Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function getContainerExtension() : ?\RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \Symplify\SimplePhpDocParser\Bundle\DependencyInjection\Extension\SimplePhpDocParserExtension();
    }
}
