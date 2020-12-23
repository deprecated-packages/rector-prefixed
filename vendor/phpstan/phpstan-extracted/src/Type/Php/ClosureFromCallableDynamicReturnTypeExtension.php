<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type\Php;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ClosureType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator;
class ClosureFromCallableDynamicReturnTypeExtension implements \_PhpScoper0a2ac50786fa\PHPStan\Type\DynamicStaticMethodReturnTypeExtension
{
    public function getClass() : string
    {
        return \Closure::class;
    }
    public function isStaticMethodSupported(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return $methodReflection->getName() === 'fromCallable';
    }
    public function getTypeFromStaticMethodCall(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection $methodReflection, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall $methodCall, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        $callableType = $scope->getType($methodCall->args[0]->value);
        if ($callableType->isCallable()->no()) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType();
        }
        $closureTypes = [];
        foreach ($callableType->getCallableParametersAcceptors($scope) as $variant) {
            $parameters = $variant->getParameters();
            $closureTypes[] = new \_PhpScoper0a2ac50786fa\PHPStan\Type\ClosureType($parameters, $variant->getReturnType(), $variant->isVariadic());
        }
        return \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::union(...$closureTypes);
    }
}
