<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\SOLID\Reflection;

use ReflectionClass;
use ReflectionClassConstant;
final class ParentConstantReflectionResolver
{
    public function resolve(string $class, string $constant) : ?\ReflectionClassConstant
    {
        $reflectionClass = new \ReflectionClass($class);
        $parentReflectionClass = $reflectionClass->getParentClass();
        while ($parentReflectionClass !== \false) {
            if ($parentReflectionClass->hasConstant($constant)) {
                return $parentReflectionClass->getReflectionConstant($constant);
            }
            $parentReflectionClass = $parentReflectionClass->getParentClass();
        }
        return null;
    }
}
