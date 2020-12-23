<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionReflection;
interface DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionReflection $functionReflection) : bool;
    public function getTypeFromFunctionCall(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type;
}
