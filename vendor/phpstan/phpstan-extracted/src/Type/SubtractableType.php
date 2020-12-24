<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type;

interface SubtractableType extends \_PhpScopere8e811afab72\PHPStan\Type\Type
{
    public function subtract(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : \_PhpScopere8e811afab72\PHPStan\Type\Type;
    public function getTypeWithoutSubtractedType() : \_PhpScopere8e811afab72\PHPStan\Type\Type;
    public function changeSubtractedType(?\_PhpScopere8e811afab72\PHPStan\Type\Type $subtractedType) : \_PhpScopere8e811afab72\PHPStan\Type\Type;
    public function getSubtractedType() : ?\_PhpScopere8e811afab72\PHPStan\Type\Type;
}
