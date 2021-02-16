<?php

declare (strict_types=1);
namespace RectorPrefix20210216\Symplify\SimplePhpDocParser\Tests\HttpKernel;

use RectorPrefix20210216\Symfony\Component\Config\Loader\LoaderInterface;
use RectorPrefix20210216\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class SimplePhpDocParserKernel extends \RectorPrefix20210216\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    public function registerContainerConfiguration(\RectorPrefix20210216\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }
}
