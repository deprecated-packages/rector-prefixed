<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider;

use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider;
class DirectReflectionProviderProvider implements \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider\ReflectionProviderProvider
{
    /** @var ReflectionProvider */
    private $reflectionProvider;
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->reflectionProvider = $reflectionProvider;
    }
    public function getReflectionProvider() : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider
    {
        return $this->reflectionProvider;
    }
}
