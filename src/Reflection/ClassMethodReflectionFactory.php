<?php

declare (strict_types=1);
namespace Rector\Core\Reflection;

use PHPStan\Type\IntersectionType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
use Rector\StaticTypeMapper\ValueObject\Type\ShortenedObjectType;
use ReflectionMethod;
final class ClassMethodReflectionFactory
{
    public function createFromPHPStanTypeAndMethodName(\PHPStan\Type\Type $type, string $methodName) : ?\ReflectionMethod
    {
        if ($type instanceof \Rector\StaticTypeMapper\ValueObject\Type\ShortenedObjectType) {
            return $this->createReflectionMethodIfExists($type->getFullyQualifiedName(), $methodName);
        }
        if ($type instanceof \PHPStan\Type\ObjectType) {
            return $this->createReflectionMethodIfExists($type->getClassName(), $methodName);
        }
        if ($type instanceof \PHPStan\Type\UnionType || $type instanceof \PHPStan\Type\IntersectionType) {
            foreach ($type->getTypes() as $unionedType) {
                if (!$unionedType instanceof \PHPStan\Type\ObjectType) {
                    continue;
                }
                $methodReflection = $this->createFromPHPStanTypeAndMethodName($unionedType, $methodName);
                if (!$methodReflection instanceof \ReflectionMethod) {
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
