<?php

declare (strict_types=1);
namespace RectorPrefix20210422\Symplify\Astral\HttpKernel;

use RectorPrefix20210422\Symfony\Component\Config\Loader\LoaderInterface;
use RectorPrefix20210422\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class AstralKernel extends \RectorPrefix20210422\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    /**
     * @return void
     */
    public function registerContainerConfiguration(\RectorPrefix20210422\Symfony\Component\Config\Loader\LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }
}
