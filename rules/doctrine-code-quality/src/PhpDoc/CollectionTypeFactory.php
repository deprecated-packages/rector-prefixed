<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\DoctrineCodeQuality\PhpDoc;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\GenericObjectType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType;
use _PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType;
final class CollectionTypeFactory
{
    public function createType(\_PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType $fullyQualifiedObjectType) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType
    {
        $genericType = $this->createGenericObjectType($fullyQualifiedObjectType);
        $arrayType = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType(new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType(), $fullyQualifiedObjectType);
        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType([$genericType, $arrayType]);
    }
    private function createGenericObjectType(\_PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType $fullyQualifiedObjectType) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        $genericTypes = [new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType(), $fullyQualifiedObjectType];
        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\GenericObjectType('_PhpScoper2a4e7ab1ecbc\\Doctrine\\Common\\Collections\\Collection', $genericTypes);
    }
}
