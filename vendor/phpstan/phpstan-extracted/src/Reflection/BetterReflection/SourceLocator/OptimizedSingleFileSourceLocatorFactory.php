<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Reflection\BetterReflection\SourceLocator;

interface OptimizedSingleFileSourceLocatorFactory
{
    public function create(string $fileName) : \RectorPrefix20201227\PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedSingleFileSourceLocator;
}
