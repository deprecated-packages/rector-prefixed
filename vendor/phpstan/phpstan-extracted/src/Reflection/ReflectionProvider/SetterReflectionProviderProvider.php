<?php

declare (strict_types=1);
namespace PHPStan\Reflection\ReflectionProvider;

use PHPStan\Reflection\ReflectionProvider;
class SetterReflectionProviderProvider implements \PHPStan\Reflection\ReflectionProvider\ReflectionProviderProvider
{
    /** @var ReflectionProvider */
    private $reflectionProvider;
    public function setReflectionProvider(\PHPStan\Reflection\ReflectionProvider $reflectionProvider) : void
    {
        $this->reflectionProvider = $reflectionProvider;
    }
    public function getReflectionProvider() : \PHPStan\Reflection\ReflectionProvider
    {
        return $this->reflectionProvider;
    }
}
