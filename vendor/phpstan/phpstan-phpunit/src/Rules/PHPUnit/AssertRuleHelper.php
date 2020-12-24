<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\PHPUnit;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
class AssertRuleHelper
{
    public static function isMethodOrStaticCallOnAssert(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : bool
    {
        $testCaseType = new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType('_PhpScopere8e811afab72\\PHPUnit\\Framework\\Assert');
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall) {
            $calledOnType = $scope->getType($node->var);
        } elseif ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall) {
            if ($node->class instanceof \_PhpScopere8e811afab72\PhpParser\Node\Name) {
                $class = (string) $node->class;
                if ($scope->isInClass() && \in_array(\strtolower($class), ['self', 'static', 'parent'], \true)) {
                    $calledOnType = new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($scope->getClassReflection()->getName());
                } else {
                    $calledOnType = new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($class);
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
