<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection;

use _PhpScopere8e811afab72\PHPStan\TrinaryLogic;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
interface MethodReflection extends \_PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberReflection
{
    public function getName() : string;
    public function getPrototype() : \_PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberReflection;
    /**
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getVariants() : array;
    public function isDeprecated() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic;
    public function getDeprecatedDescription() : ?string;
    public function isFinal() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic;
    public function isInternal() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic;
    public function getThrowType() : ?\_PhpScopere8e811afab72\PHPStan\Type\Type;
    public function hasSideEffects() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic;
}
