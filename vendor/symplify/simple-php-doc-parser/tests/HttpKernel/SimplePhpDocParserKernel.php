<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Symplify\SimplePhpDocParser\Tests\HttpKernel;

use _PhpScoper0a6b37af0871\Symfony\Component\Config\Loader\LoaderInterface;
use _PhpScoper0a6b37af0871\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class SimplePhpDocParserKernel extends \_PhpScoper0a6b37af0871\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    public function registerContainerConfiguration(\_PhpScoper0a6b37af0871\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }
}
