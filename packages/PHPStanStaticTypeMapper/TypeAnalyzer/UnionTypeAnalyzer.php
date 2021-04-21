<?php

declare (strict_types=1);
namespace Rector\PHPStanStaticTypeMapper\TypeAnalyzer;

use PHPStan\Type\ArrayType;
use PHPStan\Type\IterableType;
use PHPStan\Type\NullType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\TypeWithClassName;
use PHPStan\Type\UnionType;
use Rector\PHPStanStaticTypeMapper\ValueObject\UnionTypeAnalysis;
use Traversable;
final class UnionTypeAnalyzer
{
    public function analyseForNullableAndIterable(\PHPStan\Type\UnionType $unionType) : ?\Rector\PHPStanStaticTypeMapper\ValueObject\UnionTypeAnalysis
    {
        $isNullableType = \false;
        $hasIterable = \false;
        $hasArray = \false;
        foreach ($unionType->getTypes() as $unionedType) {
            if ($unionedType instanceof \PHPStan\Type\IterableType) {
                $hasIterable = \true;
                continue;
            }
            if ($unionedType instanceof \PHPStan\Type\ArrayType) {
                $hasArray = \true;
                continue;
            }
            if ($unionedType instanceof \PHPStan\Type\NullType) {
                $isNullableType = \true;
                continue;
            }
            if ($unionedType instanceof \PHPStan\Type\ObjectType && $unionedType->getClassName() === \Traversable::class) {
                $hasIterable = \true;
                continue;
            }
            return null;
        }
        return new \Rector\PHPStanStaticTypeMapper\ValueObject\UnionTypeAnalysis($isNullableType, $hasIterable, $hasArray);
    }
    public function hasTypeClassNameOnly(\PHPStan\Type\UnionType $unionType) : bool
    {
        foreach ($unionType->getTypes() as $unionedType) {
            if (!$unionedType instanceof \PHPStan\Type\TypeWithClassName) {
                return \false;
            }
        }
        return \true;
    }
}
