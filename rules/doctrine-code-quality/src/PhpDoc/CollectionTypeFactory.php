<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\DoctrineCodeQuality\PhpDoc;

use _PhpScoper0a6b37af0871\PHPStan\Type\ArrayType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Generic\GenericObjectType;
use _PhpScoper0a6b37af0871\PHPStan\Type\IntegerType;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\UnionType;
use _PhpScoper0a6b37af0871\Rector\PHPStan\Type\FullyQualifiedObjectType;
final class CollectionTypeFactory
{
    public function createType(\_PhpScoper0a6b37af0871\Rector\PHPStan\Type\FullyQualifiedObjectType $fullyQualifiedObjectType) : \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType
    {
        $genericType = $this->createGenericObjectType($fullyQualifiedObjectType);
        $arrayType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType(new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType(), $fullyQualifiedObjectType);
        return new \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType([$genericType, $arrayType]);
    }
    private function createGenericObjectType(\_PhpScoper0a6b37af0871\Rector\PHPStan\Type\FullyQualifiedObjectType $fullyQualifiedObjectType) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        $genericTypes = [new \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerType(), $fullyQualifiedObjectType];
        return new \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\GenericObjectType('_PhpScoper0a6b37af0871\\Doctrine\\Common\\Collections\\Collection', $genericTypes);
    }
}
