<?php

declare (strict_types=1);
namespace PHPStan\Type;

use PhpParser\Node\Expr\StaticCall;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Analyser\SpecifiedTypes;
use RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierContext;
use RectorPrefix20201227\PHPStan\Reflection\MethodReflection;
interface StaticMethodTypeSpecifyingExtension
{
    public function getClass() : string;
    public function isStaticMethodSupported(\RectorPrefix20201227\PHPStan\Reflection\MethodReflection $staticMethodReflection, \PhpParser\Node\Expr\StaticCall $node, \RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierContext $context) : bool;
    public function specifyTypes(\RectorPrefix20201227\PHPStan\Reflection\MethodReflection $staticMethodReflection, \PhpParser\Node\Expr\StaticCall $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope, \RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierContext $context) : \RectorPrefix20201227\PHPStan\Analyser\SpecifiedTypes;
}
