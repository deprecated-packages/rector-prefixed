<?php

declare (strict_types=1);
namespace PHPStan\Type\Traits;

use RectorPrefix20201227\PHPStan\Reflection\ClassMemberAccessAnswerer;
use RectorPrefix20201227\PHPStan\Reflection\TrivialParametersAcceptor;
use RectorPrefix20201227\PHPStan\TrinaryLogic;
trait MaybeCallableTypeTrait
{
    public function isCallable() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe();
    }
    /**
     * @param \PHPStan\Reflection\ClassMemberAccessAnswerer $scope
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getCallableParametersAcceptors(\RectorPrefix20201227\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        return [new \RectorPrefix20201227\PHPStan\Reflection\TrivialParametersAcceptor()];
    }
}
