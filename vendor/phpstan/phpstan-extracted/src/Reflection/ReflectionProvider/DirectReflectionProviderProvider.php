<?php

declare (strict_types=1);
namespace PHPStan\Reflection\ReflectionProvider;

use PHPStan\Reflection\ReflectionProvider;
class DirectReflectionProviderProvider implements \PHPStan\Reflection\ReflectionProvider\ReflectionProviderProvider
{
    /** @var ReflectionProvider */
    private $reflectionProvider;
    public function __construct(\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->reflectionProvider = $reflectionProvider;
    }
    public function getReflectionProvider() : \PHPStan\Reflection\ReflectionProvider
    {
        return $this->reflectionProvider;
    }
}
