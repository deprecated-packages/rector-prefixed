<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodingStyle\TypeAnalyzer;

use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\IterableType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
final class IterableTypeAnalyzer
{
    public function detect(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : bool
    {
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\ArrayType) {
            return \true;
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\IterableType) {
            return \true;
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
            foreach ($type->getTypes() as $unionedType) {
                if (!$this->detect($unionedType)) {
                    return \false;
                }
            }
            return \true;
        }
        return \false;
    }
}
