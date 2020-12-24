<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ReflectionProvider;

use _PhpScoper2a4e7ab1ecbc\PHPStan\DependencyInjection\Container;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ReflectionProvider;
class LazyReflectionProviderProvider implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ReflectionProvider\ReflectionProviderProvider
{
    /** @var Container */
    private $container;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PHPStan\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    public function getReflectionProvider() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ReflectionProvider
    {
        return $this->container->getByType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ReflectionProvider::class);
    }
}
