<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Generic;

use _PhpScopere8e811afab72\PHPStan\TrinaryLogic;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
interface TemplateTypeStrategy
{
    public function accepts(\_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateType $left, \_PhpScopere8e811afab72\PHPStan\Type\Type $right, bool $strictTypes) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic;
    public function isArgument() : bool;
}
