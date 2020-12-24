<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Symplify\SimplePhpDocParser\Tests\HttpKernel;

use _PhpScoperb75b35f52b74\Symfony\Component\Config\Loader\LoaderInterface;
use _PhpScoperb75b35f52b74\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class SimplePhpDocParserKernel extends \_PhpScoperb75b35f52b74\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    public function registerContainerConfiguration(\_PhpScoperb75b35f52b74\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }
}
