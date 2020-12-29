<?php

declare (strict_types=1);
namespace RectorPrefix20201229\Symplify\SimplePhpDocParser\Tests\HttpKernel;

use RectorPrefix20201229\Symfony\Component\Config\Loader\LoaderInterface;
use RectorPrefix20201229\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class SimplePhpDocParserKernel extends \RectorPrefix20201229\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    public function registerContainerConfiguration(\RectorPrefix20201229\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }
}
