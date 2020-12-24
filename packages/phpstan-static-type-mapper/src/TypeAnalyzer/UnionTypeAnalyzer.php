<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\TypeAnalyzer;

use _PhpScoperb75b35f52b74\PHPStan\Type\ArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\IterableType;
use _PhpScoperb75b35f52b74\PHPStan\Type\NullType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\UnionType;
use _PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\ValueObject\UnionTypeAnalysis;
use Traversable;
final class UnionTypeAnalyzer
{
    public function analyseForNullableAndIterable(\_PhpScoperb75b35f52b74\PHPStan\Type\UnionType $unionType) : ?\_PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\ValueObject\UnionTypeAnalysis
    {
        $isNullableType = \false;
        $hasIterable = \false;
        $hasArray = \false;
        foreach ($unionType->getTypes() as $unionedType) {
            if ($unionedType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\IterableType) {
                $hasIterable = \true;
                continue;
            }
            if ($unionedType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType) {
                $hasArray = \true;
                continue;
            }
            if ($unionedType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\NullType) {
                $isNullableType = \true;
                continue;
            }
            if ($unionedType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType && $unionedType->getClassName() === \Traversable::class) {
                $hasIterable = \true;
                continue;
            }
            return null;
        }
        return new \_PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\ValueObject\UnionTypeAnalysis($isNullableType, $hasIterable, $hasArray);
    }
}
