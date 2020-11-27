<?php

declare (strict_types=1);
namespace PHPStan\Type\Traits;

use PHPStan\Reflection\ClassMemberAccessAnswerer;
use PHPStan\TrinaryLogic;
trait NonCallableTypeTrait
{
    public function isCallable() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function getCallableParametersAcceptors(\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        throw new \PHPStan\ShouldNotHappenException();
    }
}
