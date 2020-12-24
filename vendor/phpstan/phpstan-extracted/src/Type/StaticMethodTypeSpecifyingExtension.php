<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\StaticCall;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\SpecifiedTypes;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\TypeSpecifierContext;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\MethodReflection;
interface StaticMethodTypeSpecifyingExtension
{
    public function getClass() : string;
    public function isStaticMethodSupported(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\MethodReflection $staticMethodReflection, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\StaticCall $node, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\TypeSpecifierContext $context) : bool;
    public function specifyTypes(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\MethodReflection $staticMethodReflection, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\StaticCall $node, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\TypeSpecifierContext $context) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\SpecifiedTypes;
}
