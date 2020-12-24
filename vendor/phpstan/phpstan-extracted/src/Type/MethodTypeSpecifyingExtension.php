<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\SpecifiedTypes;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierContext;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection;
interface MethodTypeSpecifyingExtension
{
    public function getClass() : string;
    public function isMethodSupported(\_PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection $methodReflection, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierContext $context) : bool;
    public function specifyTypes(\_PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection $methodReflection, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope, \_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierContext $context) : \_PhpScoper0a6b37af0871\PHPStan\Analyser\SpecifiedTypes;
}
