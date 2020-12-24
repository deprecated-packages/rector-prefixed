<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Traits;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
trait NonCallableTypeTrait
{
    public function isCallable() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createNo();
    }
    public function getCallableParametersAcceptors(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        throw new \_PhpScoper2a4e7ab1ecbc\PHPStan\ShouldNotHappenException();
    }
}
