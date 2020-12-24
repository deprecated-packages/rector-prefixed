<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\Reflection;

use _PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\UnionType;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\ShortenedObjectType;
use ReflectionMethod;
final class ClassMethodReflectionFactory
{
    public function createFromPHPStanTypeAndMethodName(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, string $methodName) : ?\ReflectionMethod
    {
        if ($type instanceof \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\ShortenedObjectType) {
            return $this->createReflectionMethodIfExists($type->getFullyQualifiedName(), $methodName);
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType) {
            return $this->createReflectionMethodIfExists($type->getClassName(), $methodName);
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType || $type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType) {
            foreach ($type->getTypes() as $unionedType) {
                if (!$unionedType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType) {
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
