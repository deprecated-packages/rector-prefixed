<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\DoctrineCodeQuality\PhpDoc;

use _PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Generic\GenericObjectType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\IntegerType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\MixedType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\UnionType;
use _PhpScoper0a2ac50786fa\Rector\PHPStan\Type\FullyQualifiedObjectType;
final class CollectionTypeFactory
{
    public function createType(\_PhpScoper0a2ac50786fa\Rector\PHPStan\Type\FullyQualifiedObjectType $fullyQualifiedObjectType) : \_PhpScoper0a2ac50786fa\PHPStan\Type\UnionType
    {
        $genericType = $this->createGenericObjectType($fullyQualifiedObjectType);
        $arrayType = new \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType(new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType(), $fullyQualifiedObjectType);
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\UnionType([$genericType, $arrayType]);
    }
    private function createGenericObjectType(\_PhpScoper0a2ac50786fa\Rector\PHPStan\Type\FullyQualifiedObjectType $fullyQualifiedObjectType) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        $genericTypes = [new \_PhpScoper0a2ac50786fa\PHPStan\Type\IntegerType(), $fullyQualifiedObjectType];
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\GenericObjectType('_PhpScoper0a2ac50786fa\\Doctrine\\Common\\Collections\\Collection', $genericTypes);
    }
}
