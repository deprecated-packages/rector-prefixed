<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\PHPStan\Type;

use _PhpScoper0a6b37af0871\PHPStan\Type\ArrayType;
use _PhpScoper0a6b37af0871\PHPStan\Type\BooleanType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ConstantScalarType;
use _PhpScoper0a6b37af0871\PHPStan\Type\FloatType;
use _PhpScoper0a6b37af0871\PHPStan\Type\IntegerType;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\NullType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\PHPStan\Type\StringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\UnionType;
final class StaticTypeAnalyzer
{
    public function isAlwaysTruableType(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : bool
    {
        if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType) {
            return \false;
        }
        if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantArrayType) {
            return \true;
        }
        if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType) {
            return \false;
        }
        if ($this->isNullable($type)) {
            return \false;
        }
        // always trueish
        if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType) {
            return \true;
        }
        if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ConstantScalarType && !$type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\NullType) {
            return (bool) $type->getValue();
        }
        if ($this->isScalarType($type)) {
            return \false;
        }
        return $this->isAlwaysTruableUnionType($type);
    }
    private function isNullable(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : bool
    {
        if (!$type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType) {
            return \false;
        }
        foreach ($type->getTypes() as $unionedType) {
            if ($unionedType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\NullType) {
                return \true;
            }
        }
        return \false;
    }
    private function isScalarType(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : bool
    {
        if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\NullType) {
            return \true;
        }
        return $type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\BooleanType || $type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\StringType || $type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerType || $type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\FloatType;
    }
    private function isAlwaysTruableUnionType(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : bool
    {
        if (!$type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType) {
            return \false;
        }
        foreach ($type->getTypes() as $unionedType) {
            if (!$this->isAlwaysTruableType($unionedType)) {
                return \false;
            }
        }
        return \true;
    }
}
