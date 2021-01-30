<?php

declare (strict_types=1);
namespace Rector\DoctrineCodeQuality\TypeAnalyzer;

use PHPStan\Type\ArrayType;
use PHPStan\Type\IntersectionType;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
final class TypeFinder
{
    public function find(\PHPStan\Type\Type $type, string $desiredTypeClass) : \PHPStan\Type\Type
    {
        if (\is_a($type, $desiredTypeClass, \true)) {
            return $type;
        }
        if ($type instanceof \PHPStan\Type\ArrayType && \is_a($type->getItemType(), $desiredTypeClass, \true)) {
            return $type->getItemType();
        }
        if ($type instanceof \PHPStan\Type\UnionType) {
            return $this->findInJoinedType($type, $desiredTypeClass);
        }
        if ($type instanceof \PHPStan\Type\IntersectionType) {
            return $this->findInJoinedType($type, $desiredTypeClass);
        }
        return new \PHPStan\Type\MixedType();
    }
    /**
     * @param UnionType|IntersectionType $type
     */
    private function findInJoinedType(\PHPStan\Type\Type $type, string $desiredTypeClass) : \PHPStan\Type\Type
    {
        foreach ($type->getTypes() as $joinedType) {
            $foundType = $this->find($joinedType, $desiredTypeClass);
            if (!$foundType instanceof \PHPStan\Type\MixedType) {
                return $foundType;
            }
        }
        return new \PHPStan\Type\MixedType();
    }
}
