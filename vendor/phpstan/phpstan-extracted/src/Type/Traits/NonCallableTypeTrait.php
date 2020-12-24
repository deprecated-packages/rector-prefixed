<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type\Traits;

use _PhpScoper0a6b37af0871\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScoper0a6b37af0871\PHPStan\TrinaryLogic;
trait NonCallableTypeTrait
{
    public function isCallable() : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createNo();
    }
    public function getCallableParametersAcceptors(\_PhpScoper0a6b37af0871\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        throw new \_PhpScoper0a6b37af0871\PHPStan\ShouldNotHappenException();
    }
}
