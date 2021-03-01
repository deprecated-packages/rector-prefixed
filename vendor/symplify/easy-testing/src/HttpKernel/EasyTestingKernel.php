<?php

declare (strict_types=1);
namespace RectorPrefix20210301\Symplify\EasyTesting\HttpKernel;

use RectorPrefix20210301\Symfony\Component\Config\Loader\LoaderInterface;
use RectorPrefix20210301\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class EasyTestingKernel extends \RectorPrefix20210301\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    public function registerContainerConfiguration(\RectorPrefix20210301\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }
}
