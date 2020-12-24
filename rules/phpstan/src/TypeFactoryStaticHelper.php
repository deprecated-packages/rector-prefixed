<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PHPStan;

use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\UnionType;
use ReflectionClass;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
final class TypeFactoryStaticHelper
{
    /**
     * @param string[]|Type[] $types
     */
    public static function createUnionObjectType(array $types) : \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType
    {
        $objectTypes = [];
        foreach ($types as $type) {
            $objectTypes[] = $type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Type ? $type : new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($type);
        }
        // this is needed to prevent missing broker static fatal error, for tests with missing class
        $reflectionClass = new \ReflectionClass(\_PhpScoperb75b35f52b74\PHPStan\Type\UnionType::class);
        /** @var UnionType $unionType */
        $unionType = $reflectionClass->newInstanceWithoutConstructor();
        $privatesAccessor = new \_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Reflection\PrivatesAccessor();
        $privatesAccessor->setPrivateProperty($unionType, 'types', $objectTypes);
        return $unionType;
    }
}
