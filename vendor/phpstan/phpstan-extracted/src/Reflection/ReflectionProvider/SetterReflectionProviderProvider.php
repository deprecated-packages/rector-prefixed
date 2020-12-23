<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider;

use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider;
class SetterReflectionProviderProvider implements \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider\ReflectionProviderProvider
{
    /** @var ReflectionProvider */
    private $reflectionProvider;
    public function setReflectionProvider(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider $reflectionProvider) : void
    {
        $this->reflectionProvider = $reflectionProvider;
    }
    public function getReflectionProvider() : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider
    {
        return $this->reflectionProvider;
    }
}
