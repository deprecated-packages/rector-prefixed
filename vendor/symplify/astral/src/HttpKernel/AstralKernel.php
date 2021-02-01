<?php

declare (strict_types=1);
namespace RectorPrefix20210201\Symplify\Astral\HttpKernel;

use RectorPrefix20210201\Symfony\Component\Config\Loader\LoaderInterface;
use RectorPrefix20210201\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class AstralKernel extends \RectorPrefix20210201\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    public function registerContainerConfiguration(\RectorPrefix20210201\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }
}
