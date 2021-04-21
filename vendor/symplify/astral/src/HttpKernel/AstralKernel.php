<?php

declare(strict_types=1);

namespace Symplify\Astral\HttpKernel;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;

final class AstralKernel extends AbstractSymplifyKernel
{
    /**
     * @return void
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }
}
