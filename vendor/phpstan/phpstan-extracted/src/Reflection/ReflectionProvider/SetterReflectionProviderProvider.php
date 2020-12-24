<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider;

use _PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider;
class SetterReflectionProviderProvider implements \_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider\ReflectionProviderProvider
{
    /** @var ReflectionProvider */
    private $reflectionProvider;
    public function setReflectionProvider(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider $reflectionProvider) : void
    {
        $this->reflectionProvider = $reflectionProvider;
    }
    public function getReflectionProvider() : \_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider
    {
        return $this->reflectionProvider;
    }
}
