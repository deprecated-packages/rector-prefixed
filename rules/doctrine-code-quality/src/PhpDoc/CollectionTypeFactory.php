<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DoctrineCodeQuality\PhpDoc;

use _PhpScoperb75b35f52b74\PHPStan\Type\ArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\IntegerType;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\UnionType;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType;
final class CollectionTypeFactory
{
    public function createType(\_PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType $fullyQualifiedObjectType) : \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType
    {
        $genericType = $this->createGenericObjectType($fullyQualifiedObjectType);
        $arrayType = new \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType(new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType(), $fullyQualifiedObjectType);
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType([$genericType, $arrayType]);
    }
    private function createGenericObjectType(\_PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType $fullyQualifiedObjectType) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $genericTypes = [new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType(), $fullyQualifiedObjectType];
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericObjectType('_PhpScoperb75b35f52b74\\Doctrine\\Common\\Collections\\Collection', $genericTypes);
    }
}
