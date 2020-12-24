<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PHPStan;

use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
use ReflectionClass;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
final class TypeFactoryStaticHelper
{
    /**
     * @param string[]|Type[] $types
     */
    public static function createUnionObjectType(array $types) : \_PhpScopere8e811afab72\PHPStan\Type\UnionType
    {
        $objectTypes = [];
        foreach ($types as $type) {
            $objectTypes[] = $type instanceof \_PhpScopere8e811afab72\PHPStan\Type\Type ? $type : new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($type);
        }
        // this is needed to prevent missing broker static fatal error, for tests with missing class
        $reflectionClass = new \ReflectionClass(\_PhpScopere8e811afab72\PHPStan\Type\UnionType::class);
        /** @var UnionType $unionType */
        $unionType = $reflectionClass->newInstanceWithoutConstructor();
        $privatesAccessor = new \_PhpScopere8e811afab72\Symplify\PackageBuilder\Reflection\PrivatesAccessor();
        $privatesAccessor->setPrivateProperty($unionType, 'types', $objectTypes);
        return $unionType;
    }
}
