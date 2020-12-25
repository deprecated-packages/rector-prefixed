<?php

declare (strict_types=1);
namespace PHPStan\Reflection\ReflectionProvider;

use PHPStan\DependencyInjection\Container;
use PHPStan\Reflection\ReflectionProvider;
class LazyReflectionProviderProvider implements \PHPStan\Reflection\ReflectionProvider\ReflectionProviderProvider
{
    /** @var Container */
    private $container;
    public function __construct(\PHPStan\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    public function getReflectionProvider() : \PHPStan\Reflection\ReflectionProvider
    {
        return $this->container->getByType(\PHPStan\Reflection\ReflectionProvider::class);
    }
}
