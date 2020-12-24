<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider;

use _PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider;
class SetterReflectionProviderProvider implements \_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider\ReflectionProviderProvider
{
    /** @var ReflectionProvider */
    private $reflectionProvider;
    public function setReflectionProvider(\_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider $reflectionProvider) : void
    {
        $this->reflectionProvider = $reflectionProvider;
    }
    public function getReflectionProvider() : \_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider
    {
        return $this->reflectionProvider;
    }
}
