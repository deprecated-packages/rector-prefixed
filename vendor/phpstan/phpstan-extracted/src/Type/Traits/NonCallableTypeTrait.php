<?php

declare (strict_types=1);
namespace PHPStan\Type\Traits;

use RectorPrefix20201227\PHPStan\Reflection\ClassMemberAccessAnswerer;
use RectorPrefix20201227\PHPStan\TrinaryLogic;
trait NonCallableTypeTrait
{
    public function isCallable() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
    }
    public function getCallableParametersAcceptors(\RectorPrefix20201227\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
    }
}
