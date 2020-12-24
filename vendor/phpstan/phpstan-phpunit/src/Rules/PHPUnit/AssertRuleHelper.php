<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\PHPUnit;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType;
class AssertRuleHelper
{
    public static function isMethodOrStaticCallOnAssert(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : bool
    {
        $testCaseType = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType('_PhpScoper2a4e7ab1ecbc\\PHPUnit\\Framework\\Assert');
        if ($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall) {
            $calledOnType = $scope->getType($node->var);
        } elseif ($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\StaticCall) {
            if ($node->class instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name) {
                $class = (string) $node->class;
                if ($scope->isInClass() && \in_array(\strtolower($class), ['self', 'static', 'parent'], \true)) {
                    $calledOnType = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType($scope->getClassReflection()->getName());
                } else {
                    $calledOnType = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType($class);
                }
            } else {
                $calledOnType = $scope->getType($node->class);
            }
        } else {
            return \false;
        }
        if (!$testCaseType->isSuperTypeOf($calledOnType)->yes()) {
            return \false;
        }
        return \true;
    }
}
