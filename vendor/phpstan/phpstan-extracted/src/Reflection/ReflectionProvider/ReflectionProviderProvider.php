<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider;

use RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider;
interface ReflectionProviderProvider
{
    public function getReflectionProvider() : \RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider;
}
