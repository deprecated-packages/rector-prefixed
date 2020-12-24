<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider;

use _PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider;
class DirectReflectionProviderProvider implements \_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider\ReflectionProviderProvider
{
    /** @var ReflectionProvider */
    private $reflectionProvider;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->reflectionProvider = $reflectionProvider;
    }
    public function getReflectionProvider() : \_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider
    {
        return $this->reflectionProvider;
    }
}
