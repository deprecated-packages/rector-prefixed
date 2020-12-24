<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Symplify\SimplePhpDocParser\Bundle;

use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use _PhpScoperb75b35f52b74\Symfony\Component\HttpKernel\Bundle\Bundle;
use _PhpScoperb75b35f52b74\Symplify\SimplePhpDocParser\Bundle\DependencyInjection\Extension\SimplePhpDocParserExtension;
final class SimplePhpDocParserBundle extends \_PhpScoperb75b35f52b74\Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function getContainerExtension() : ?\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \_PhpScoperb75b35f52b74\Symplify\SimplePhpDocParser\Bundle\DependencyInjection\Extension\SimplePhpDocParserExtension();
    }
}
