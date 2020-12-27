<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Reflection\BetterReflection\SourceLocator;

interface OptimizedDirectorySourceLocatorFactory
{
    public function create(string $directory) : \RectorPrefix20201227\PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedDirectorySourceLocator;
}
