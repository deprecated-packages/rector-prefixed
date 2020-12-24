<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\TypeAnalyzer;

use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\IterableType;
use _PhpScopere8e811afab72\PHPStan\Type\NullType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
use _PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\ValueObject\UnionTypeAnalysis;
use Traversable;
final class UnionTypeAnalyzer
{
    public function analyseForNullableAndIterable(\_PhpScopere8e811afab72\PHPStan\Type\UnionType $unionType) : ?\_PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\ValueObject\UnionTypeAnalysis
    {
        $isNullableType = \false;
        $hasIterable = \false;
        $hasArray = \false;
        foreach ($unionType->getTypes() as $unionedType) {
            if ($unionedType instanceof \_PhpScopere8e811afab72\PHPStan\Type\IterableType) {
                $hasIterable = \true;
                continue;
            }
            if ($unionedType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ArrayType) {
                $hasArray = \true;
                continue;
            }
            if ($unionedType instanceof \_PhpScopere8e811afab72\PHPStan\Type\NullType) {
                $isNullableType = \true;
                continue;
            }
            if ($unionedType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ObjectType && $unionedType->getClassName() === \Traversable::class) {
                $hasIterable = \true;
                continue;
            }
            return null;
        }
        return new \_PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\ValueObject\UnionTypeAnalysis($isNullableType, $hasIterable, $hasArray);
    }
}
