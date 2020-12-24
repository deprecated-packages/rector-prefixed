<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\Reflection;

use _PhpScopere8e811afab72\PHPStan\Type\IntersectionType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
use _PhpScopere8e811afab72\Rector\PHPStan\Type\ShortenedObjectType;
use ReflectionMethod;
final class ClassMethodReflectionFactory
{
    public function createFromPHPStanTypeAndMethodName(\_PhpScopere8e811afab72\PHPStan\Type\Type $type, string $methodName) : ?\ReflectionMethod
    {
        if ($type instanceof \_PhpScopere8e811afab72\Rector\PHPStan\Type\ShortenedObjectType) {
            return $this->createReflectionMethodIfExists($type->getFullyQualifiedName(), $methodName);
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\ObjectType) {
            return $this->createReflectionMethodIfExists($type->getClassName(), $methodName);
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType || $type instanceof \_PhpScopere8e811afab72\PHPStan\Type\IntersectionType) {
            foreach ($type->getTypes() as $unionedType) {
                if (!$unionedType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ObjectType) {
                    continue;
                }
                $methodReflection = $this->createFromPHPStanTypeAndMethodName($unionedType, $methodName);
                if ($methodReflection === null) {
                    continue;
                }
                return $methodReflection;
            }
        }
        return null;
    }
    public function createReflectionMethodIfExists(string $class, string $method) : ?\ReflectionMethod
    {
        if (!\method_exists($class, $method)) {
            return null;
        }
        return new \ReflectionMethod($class, $method);
    }
}
