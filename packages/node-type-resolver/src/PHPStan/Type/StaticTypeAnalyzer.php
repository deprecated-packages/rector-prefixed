<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\PHPStan\Type;

use _PhpScoperb75b35f52b74\PHPStan\Type\ArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\BooleanType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ConstantScalarType;
use _PhpScoperb75b35f52b74\PHPStan\Type\FloatType;
use _PhpScoperb75b35f52b74\PHPStan\Type\IntegerType;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\NullType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\StringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\UnionType;
final class StaticTypeAnalyzer
{
    public function isAlwaysTruableType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : bool
    {
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType) {
            return \false;
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayType) {
            return \true;
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType) {
            return \false;
        }
        if ($this->isNullable($type)) {
            return \false;
        }
        // always trueish
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType) {
            return \true;
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ConstantScalarType && !$type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\NullType) {
            return (bool) $type->getValue();
        }
        if ($this->isScalarType($type)) {
            return \false;
        }
        return $this->isAlwaysTruableUnionType($type);
    }
    private function isNullable(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : bool
    {
        if (!$type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType) {
            return \false;
        }
        foreach ($type->getTypes() as $unionedType) {
            if ($unionedType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\NullType) {
                return \true;
            }
        }
        return \false;
    }
    private function isScalarType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : bool
    {
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\NullType) {
            return \true;
        }
        return $type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\BooleanType || $type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\StringType || $type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType || $type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\FloatType;
    }
    private function isAlwaysTruableUnionType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : bool
    {
        if (!$type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType) {
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
