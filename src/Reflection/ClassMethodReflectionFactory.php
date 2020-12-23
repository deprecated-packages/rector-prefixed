<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Core\Reflection;

use _PhpScoper0a2ac50786fa\PHPStan\Type\IntersectionType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\UnionType;
use _PhpScoper0a2ac50786fa\Rector\PHPStan\Type\ShortenedObjectType;
use ReflectionMethod;
final class ClassMethodReflectionFactory
{
    public function createFromPHPStanTypeAndMethodName(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type, string $methodName) : ?\ReflectionMethod
    {
        if ($type instanceof \_PhpScoper0a2ac50786fa\Rector\PHPStan\Type\ShortenedObjectType) {
            return $this->createReflectionMethodIfExists($type->getFullyQualifiedName(), $methodName);
        }
        if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType) {
            return $this->createReflectionMethodIfExists($type->getClassName(), $methodName);
        }
        if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\UnionType || $type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\IntersectionType) {
            foreach ($type->getTypes() as $unionedType) {
                if (!$unionedType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType) {
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
