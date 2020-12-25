<?php

declare (strict_types=1);
namespace PHPStan\Type;

use PhpParser\Node\Expr\StaticCall;
use PHPStan\Analyser\Scope;
use PHPStan\Analyser\SpecifiedTypes;
use PHPStan\Analyser\TypeSpecifierContext;
use PHPStan\Reflection\MethodReflection;
interface StaticMethodTypeSpecifyingExtension
{
    public function getClass() : string;
    public function isStaticMethodSupported(\PHPStan\Reflection\MethodReflection $staticMethodReflection, \PhpParser\Node\Expr\StaticCall $node, \PHPStan\Analyser\TypeSpecifierContext $context) : bool;
    public function specifyTypes(\PHPStan\Reflection\MethodReflection $staticMethodReflection, \PhpParser\Node\Expr\StaticCall $node, \PHPStan\Analyser\Scope $scope, \PHPStan\Analyser\TypeSpecifierContext $context) : \PHPStan\Analyser\SpecifiedTypes;
}
