<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider;

use _PhpScoper0a6b37af0871\PHPStan\DependencyInjection\Container;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider;
class LazyReflectionProviderProvider implements \_PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider\ReflectionProviderProvider
{
    /** @var Container */
    private $container;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    public function getReflectionProvider() : \_PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider
    {
        return $this->container->getByType(\_PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider::class);
    }
}
