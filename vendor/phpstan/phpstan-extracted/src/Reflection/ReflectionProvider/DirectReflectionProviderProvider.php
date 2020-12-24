<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider;

use _PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider;
class DirectReflectionProviderProvider implements \_PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider\ReflectionProviderProvider
{
    /** @var ReflectionProvider */
    private $reflectionProvider;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->reflectionProvider = $reflectionProvider;
    }
    public function getReflectionProvider() : \_PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider
    {
        return $this->reflectionProvider;
    }
}
