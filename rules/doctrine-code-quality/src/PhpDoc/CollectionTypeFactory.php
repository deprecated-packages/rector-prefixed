<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DoctrineCodeQuality\PhpDoc;

use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\GenericObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\IntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
use _PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType;
final class CollectionTypeFactory
{
    public function createType(\_PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType $fullyQualifiedObjectType) : \_PhpScopere8e811afab72\PHPStan\Type\UnionType
    {
        $genericType = $this->createGenericObjectType($fullyQualifiedObjectType);
        $arrayType = new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\MixedType(), $fullyQualifiedObjectType);
        return new \_PhpScopere8e811afab72\PHPStan\Type\UnionType([$genericType, $arrayType]);
    }
    private function createGenericObjectType(\_PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType $fullyQualifiedObjectType) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $genericTypes = [new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType(), $fullyQualifiedObjectType];
        return new \_PhpScopere8e811afab72\PHPStan\Type\Generic\GenericObjectType('_PhpScopere8e811afab72\\Doctrine\\Common\\Collections\\Collection', $genericTypes);
    }
}
