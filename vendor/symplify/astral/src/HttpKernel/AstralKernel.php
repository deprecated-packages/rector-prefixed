<?php

declare (strict_types=1);
namespace RectorPrefix20210208\Symplify\Astral\HttpKernel;

use RectorPrefix20210208\Symfony\Component\Config\Loader\LoaderInterface;
use RectorPrefix20210208\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class AstralKernel extends \RectorPrefix20210208\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    public function registerContainerConfiguration(\RectorPrefix20210208\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }
}
