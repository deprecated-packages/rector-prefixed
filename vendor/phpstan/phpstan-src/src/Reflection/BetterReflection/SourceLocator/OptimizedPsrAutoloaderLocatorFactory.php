<?php

declare (strict_types=1);
namespace PHPStan\Reflection\BetterReflection\SourceLocator;

use _PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\Type\Composer\Psr\PsrAutoloaderMapping;
interface OptimizedPsrAutoloaderLocatorFactory
{
    public function create(\_PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\Type\Composer\Psr\PsrAutoloaderMapping $mapping) : \PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedPsrAutoloaderLocator;
}
