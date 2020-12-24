<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PHPStanStaticTypeMapper\TypeAnalyzer;

use _PhpScoper0a6b37af0871\PHPStan\Type\ArrayType;
use _PhpScoper0a6b37af0871\PHPStan\Type\IterableType;
use _PhpScoper0a6b37af0871\PHPStan\Type\NullType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\PHPStan\Type\UnionType;
use _PhpScoper0a6b37af0871\Rector\PHPStanStaticTypeMapper\ValueObject\UnionTypeAnalysis;
use Traversable;
final class UnionTypeAnalyzer
{
    public function analyseForNullableAndIterable(\_PhpScoper0a6b37af0871\PHPStan\Type\UnionType $unionType) : ?\_PhpScoper0a6b37af0871\Rector\PHPStanStaticTypeMapper\ValueObject\UnionTypeAnalysis
    {
        $isNullableType = \false;
        $hasIterable = \false;
        $hasArray = \false;
        foreach ($unionType->getTypes() as $unionedType) {
            if ($unionedType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IterableType) {
                $hasIterable = \true;
                continue;
            }
            if ($unionedType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType) {
                $hasArray = \true;
                continue;
            }
            if ($unionedType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\NullType) {
                $isNullableType = \true;
                continue;
            }
            if ($unionedType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType && $unionedType->getClassName() === \Traversable::class) {
                $hasIterable = \true;
                continue;
            }
            return null;
        }
        return new \_PhpScoper0a6b37af0871\Rector\PHPStanStaticTypeMapper\ValueObject\UnionTypeAnalysis($isNullableType, $hasIterable, $hasArray);
    }
}
