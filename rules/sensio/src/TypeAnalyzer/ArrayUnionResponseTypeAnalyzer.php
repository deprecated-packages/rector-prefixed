<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Sensio\TypeAnalyzer;

use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
final class ArrayUnionResponseTypeAnalyzer
{
    public function isArrayUnionResponseType(\_PhpScopere8e811afab72\PHPStan\Type\Type $type, string $className) : bool
    {
        if (!$type instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
            return \false;
        }
        $hasArrayType = \false;
        $hasResponseType = \false;
        foreach ($type->getTypes() as $unionedType) {
            if ($unionedType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ArrayType) {
                $hasArrayType = \true;
                continue;
            }
            if ($this->isTypeOfClassName($unionedType, $className)) {
                $hasResponseType = \true;
                continue;
            }
            return \false;
        }
        if (!$hasArrayType) {
            return \false;
        }
        return $hasResponseType;
    }
    private function isTypeOfClassName(\_PhpScopere8e811afab72\PHPStan\Type\Type $type, string $className) : bool
    {
        if (!$type instanceof \_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName) {
            return \false;
        }
        return \is_a($type->getClassName(), $className, \true);
    }
}
