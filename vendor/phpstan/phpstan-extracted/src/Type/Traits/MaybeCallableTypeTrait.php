<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Traits;

use _PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScopere8e811afab72\PHPStan\Reflection\TrivialParametersAcceptor;
use _PhpScopere8e811afab72\PHPStan\TrinaryLogic;
trait MaybeCallableTypeTrait
{
    public function isCallable() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
    }
    /**
     * @param \PHPStan\Reflection\ClassMemberAccessAnswerer $scope
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getCallableParametersAcceptors(\_PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        return [new \_PhpScopere8e811afab72\PHPStan\Reflection\TrivialParametersAcceptor()];
    }
}
