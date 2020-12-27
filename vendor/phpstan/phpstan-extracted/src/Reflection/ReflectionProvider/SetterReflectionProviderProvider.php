<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider;

use RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider;
class SetterReflectionProviderProvider implements \RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider\ReflectionProviderProvider
{
    /** @var ReflectionProvider */
    private $reflectionProvider;
    public function setReflectionProvider(\RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider $reflectionProvider) : void
    {
        $this->reflectionProvider = $reflectionProvider;
    }
    public function getReflectionProvider() : \RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider
    {
        return $this->reflectionProvider;
    }
}
