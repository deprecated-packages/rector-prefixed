<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection;

use _PhpScopere8e811afab72\PHPStan\TrinaryLogic;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
interface PropertyReflection extends \_PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberReflection
{
    public function getReadableType() : \_PhpScopere8e811afab72\PHPStan\Type\Type;
    public function getWritableType() : \_PhpScopere8e811afab72\PHPStan\Type\Type;
    public function canChangeTypeAfterAssignment() : bool;
    public function isReadable() : bool;
    public function isWritable() : bool;
    public function isDeprecated() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic;
    public function getDeprecatedDescription() : ?string;
    public function isInternal() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic;
}
