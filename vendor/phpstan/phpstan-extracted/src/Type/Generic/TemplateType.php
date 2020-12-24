<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Generic;

use _PhpScopere8e811afab72\PHPStan\Type\CompoundType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
interface TemplateType extends \_PhpScopere8e811afab72\PHPStan\Type\CompoundType
{
    public function getName() : string;
    public function getScope() : \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeScope;
    public function getBound() : \_PhpScopere8e811afab72\PHPStan\Type\Type;
    public function toArgument() : \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateType;
    public function isArgument() : bool;
    public function isValidVariance(\_PhpScopere8e811afab72\PHPStan\Type\Type $a, \_PhpScopere8e811afab72\PHPStan\Type\Type $b) : bool;
    public function getVariance() : \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeVariance;
}
