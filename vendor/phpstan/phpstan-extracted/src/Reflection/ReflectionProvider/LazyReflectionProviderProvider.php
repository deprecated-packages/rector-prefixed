<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider;

use RectorPrefix20201227\PHPStan\DependencyInjection\Container;
use RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider;
class LazyReflectionProviderProvider implements \RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider\ReflectionProviderProvider
{
    /** @var Container */
    private $container;
    public function __construct(\RectorPrefix20201227\PHPStan\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    public function getReflectionProvider() : \RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider
    {
        return $this->container->getByType(\RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider::class);
    }
}
