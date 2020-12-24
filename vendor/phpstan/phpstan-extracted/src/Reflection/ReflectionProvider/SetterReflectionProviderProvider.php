<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ReflectionProvider;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ReflectionProvider;
class SetterReflectionProviderProvider implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ReflectionProvider\ReflectionProviderProvider
{
    /** @var ReflectionProvider */
    private $reflectionProvider;
    public function setReflectionProvider(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ReflectionProvider $reflectionProvider) : void
    {
        $this->reflectionProvider = $reflectionProvider;
    }
    public function getReflectionProvider() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ReflectionProvider
    {
        return $this->reflectionProvider;
    }
}
