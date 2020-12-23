<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Symplify\SimplePhpDocParser\Tests\HttpKernel;

use _PhpScoper0a2ac50786fa\Symfony\Component\Config\Loader\LoaderInterface;
use _PhpScoper0a2ac50786fa\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class SimplePhpDocParserKernel extends \_PhpScoper0a2ac50786fa\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    public function registerContainerConfiguration(\_PhpScoper0a2ac50786fa\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }
}
