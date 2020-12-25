<?php

declare (strict_types=1);
namespace PHPStan\Type;

use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Analyser\SpecifiedTypes;
use PHPStan\Analyser\TypeSpecifierContext;
use PHPStan\Reflection\MethodReflection;
interface MethodTypeSpecifyingExtension
{
    public function getClass() : string;
    public function isMethodSupported(\PHPStan\Reflection\MethodReflection $methodReflection, \PhpParser\Node\Expr\MethodCall $node, \PHPStan\Analyser\TypeSpecifierContext $context) : bool;
    public function specifyTypes(\PHPStan\Reflection\MethodReflection $methodReflection, \PhpParser\Node\Expr\MethodCall $node, \PHPStan\Analyser\Scope $scope, \PHPStan\Analyser\TypeSpecifierContext $context) : \PHPStan\Analyser\SpecifiedTypes;
}
