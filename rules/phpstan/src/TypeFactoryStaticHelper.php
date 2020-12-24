<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PHPStan;

use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\UnionType;
use ReflectionClass;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
final class TypeFactoryStaticHelper
{
    /**
     * @param string[]|Type[] $types
     */
    public static function createUnionObjectType(array $types) : \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType
    {
        $objectTypes = [];
        foreach ($types as $type) {
            $objectTypes[] = $type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Type ? $type : new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType($type);
        }
        // this is needed to prevent missing broker static fatal error, for tests with missing class
        $reflectionClass = new \ReflectionClass(\_PhpScoper0a6b37af0871\PHPStan\Type\UnionType::class);
        /** @var UnionType $unionType */
        $unionType = $reflectionClass->newInstanceWithoutConstructor();
        $privatesAccessor = new \_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Reflection\PrivatesAccessor();
        $privatesAccessor->setPrivateProperty($unionType, 'types', $objectTypes);
        return $unionType;
    }
}
