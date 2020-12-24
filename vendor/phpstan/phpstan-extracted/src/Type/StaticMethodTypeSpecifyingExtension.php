<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\SpecifiedTypes;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierContext;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection;
interface StaticMethodTypeSpecifyingExtension
{
    public function getClass() : string;
    public function isStaticMethodSupported(\_PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection $staticMethodReflection, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierContext $context) : bool;
    public function specifyTypes(\_PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection $staticMethodReflection, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope, \_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierContext $context) : \_PhpScoper0a6b37af0871\PHPStan\Analyser\SpecifiedTypes;
}
