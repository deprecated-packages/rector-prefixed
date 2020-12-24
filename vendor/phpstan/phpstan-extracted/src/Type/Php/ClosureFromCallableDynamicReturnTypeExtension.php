<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type\Php;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection;
use _PhpScoper0a6b37af0871\PHPStan\Type\ClosureType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ErrorType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator;
class ClosureFromCallableDynamicReturnTypeExtension implements \_PhpScoper0a6b37af0871\PHPStan\Type\DynamicStaticMethodReturnTypeExtension
{
    public function getClass() : string
    {
        return \Closure::class;
    }
    public function isStaticMethodSupported(\_PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return $methodReflection->getName() === 'fromCallable';
    }
    public function getTypeFromStaticMethodCall(\_PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection $methodReflection, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall $methodCall, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        $callableType = $scope->getType($methodCall->args[0]->value);
        if ($callableType->isCallable()->no()) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\ErrorType();
        }
        $closureTypes = [];
        foreach ($callableType->getCallableParametersAcceptors($scope) as $variant) {
            $parameters = $variant->getParameters();
            $closureTypes[] = new \_PhpScoper0a6b37af0871\PHPStan\Type\ClosureType($parameters, $variant->getReturnType(), $variant->isVariadic());
        }
        return \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::union(...$closureTypes);
    }
}
