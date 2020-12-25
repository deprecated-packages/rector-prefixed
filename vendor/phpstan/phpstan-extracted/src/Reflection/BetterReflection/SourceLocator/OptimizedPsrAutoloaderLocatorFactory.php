<?php

declare (strict_types=1);
namespace PHPStan\Reflection\BetterReflection\SourceLocator;

use _HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\Composer\Psr\PsrAutoloaderMapping;
interface OptimizedPsrAutoloaderLocatorFactory
{
    public function create(\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\Composer\Psr\PsrAutoloaderMapping $mapping) : \PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedPsrAutoloaderLocator;
}
