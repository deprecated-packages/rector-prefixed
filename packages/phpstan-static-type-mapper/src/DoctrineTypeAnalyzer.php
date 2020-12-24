<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper;

use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
final class DoctrineTypeAnalyzer
{
    public function isDoctrineCollectionWithIterableUnionType(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : bool
    {
        if (!$type instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
            return \false;
        }
        $arrayType = null;
        $hasDoctrineCollectionType = \false;
        foreach ($type->getTypes() as $unionedType) {
            if ($this->isCollectionObjectType($unionedType)) {
                $hasDoctrineCollectionType = \true;
            }
            if ($unionedType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ArrayType) {
                $arrayType = $unionedType;
            }
        }
        if (!$hasDoctrineCollectionType) {
            return \false;
        }
        return $arrayType !== null;
    }
    private function isCollectionObjectType(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : bool
    {
        if (!$type instanceof \_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName) {
            return \false;
        }
        return $type->getClassName() === 'Doctrine\\Common\\Collections\\Collection';
    }
}
