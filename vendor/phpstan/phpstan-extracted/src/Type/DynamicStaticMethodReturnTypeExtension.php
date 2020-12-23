<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection;
interface DynamicStaticMethodReturnTypeExtension
{
    public function getClass() : string;
    public function isStaticMethodSupported(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection $methodReflection) : bool;
    public function getTypeFromStaticMethodCall(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection $methodReflection, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall $methodCall, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type;
}
