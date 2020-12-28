<?php

declare (strict_types=1);
namespace RectorPrefix20201228\Symplify\SimplePhpDocParser\Tests\HttpKernel;

use RectorPrefix20201228\Symfony\Component\Config\Loader\LoaderInterface;
use RectorPrefix20201228\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class SimplePhpDocParserKernel extends \RectorPrefix20201228\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    public function registerContainerConfiguration(\RectorPrefix20201228\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }
}
