<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection;

use _PhpScopere8e811afab72\PHPStan\TrinaryLogic;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
interface GlobalConstantReflection
{
    public function getName() : string;
    public function getValueType() : \_PhpScopere8e811afab72\PHPStan\Type\Type;
    public function isDeprecated() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic;
    public function getDeprecatedDescription() : ?string;
    public function isInternal() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic;
    public function getFileName() : ?string;
}
