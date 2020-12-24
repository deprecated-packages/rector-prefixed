<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper;

use _PhpScoperb75b35f52b74\PHPStan\Type\ArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName;
use _PhpScoperb75b35f52b74\PHPStan\Type\UnionType;
final class DoctrineTypeAnalyzer
{
    public function isDoctrineCollectionWithIterableUnionType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : bool
    {
        if (!$type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType) {
            return \false;
        }
        $arrayType = null;
        $hasDoctrineCollectionType = \false;
        foreach ($type->getTypes() as $unionedType) {
            if ($this->isCollectionObjectType($unionedType)) {
                $hasDoctrineCollectionType = \true;
            }
            if ($unionedType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType) {
                $arrayType = $unionedType;
            }
        }
        if (!$hasDoctrineCollectionType) {
            return \false;
        }
        return $arrayType !== null;
    }
    private function isCollectionObjectType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : bool
    {
        if (!$type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName) {
            return \false;
        }
        return $type->getClassName() === 'Doctrine\\Common\\Collections\\Collection';
    }
}
