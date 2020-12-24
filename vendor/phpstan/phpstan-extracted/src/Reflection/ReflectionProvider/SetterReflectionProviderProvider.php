<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider;

use _PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider;
class SetterReflectionProviderProvider implements \_PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider\ReflectionProviderProvider
{
    /** @var ReflectionProvider */
    private $reflectionProvider;
    public function setReflectionProvider(\_PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider $reflectionProvider) : void
    {
        $this->reflectionProvider = $reflectionProvider;
    }
    public function getReflectionProvider() : \_PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider
    {
        return $this->reflectionProvider;
    }
}
