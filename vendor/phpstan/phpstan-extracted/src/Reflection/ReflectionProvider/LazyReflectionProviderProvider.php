<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider;

use _PhpScopere8e811afab72\PHPStan\DependencyInjection\Container;
use _PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider;
class LazyReflectionProviderProvider implements \_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider\ReflectionProviderProvider
{
    /** @var Container */
    private $container;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    public function getReflectionProvider() : \_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider
    {
        return $this->container->getByType(\_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider::class);
    }
}
