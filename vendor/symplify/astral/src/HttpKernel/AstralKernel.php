<?php

declare (strict_types=1);
namespace RectorPrefix20210420\Symplify\Astral\HttpKernel;

use RectorPrefix20210420\Symfony\Component\Config\Loader\LoaderInterface;
use RectorPrefix20210420\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class AstralKernel extends \RectorPrefix20210420\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    /**
     * @return void
     */
    public function registerContainerConfiguration(\RectorPrefix20210420\Symfony\Component\Config\Loader\LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }
}
