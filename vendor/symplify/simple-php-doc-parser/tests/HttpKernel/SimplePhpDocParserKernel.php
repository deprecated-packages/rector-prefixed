<?php

declare (strict_types=1);
namespace Symplify\SimplePhpDocParser\Tests\HttpKernel;

use _PhpScoperbf340cb0be9d\Symfony\Component\Config\Loader\LoaderInterface;
use Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class SimplePhpDocParserKernel extends \Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    public function registerContainerConfiguration(\_PhpScoperbf340cb0be9d\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }
}
