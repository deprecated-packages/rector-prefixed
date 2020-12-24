<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Symplify\SimplePhpDocParser\Tests\HttpKernel;

use _PhpScoper2a4e7ab1ecbc\Symfony\Component\Config\Loader\LoaderInterface;
use _PhpScoper2a4e7ab1ecbc\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class SimplePhpDocParserKernel extends \_PhpScoper2a4e7ab1ecbc\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    public function registerContainerConfiguration(\_PhpScoper2a4e7ab1ecbc\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }
}
