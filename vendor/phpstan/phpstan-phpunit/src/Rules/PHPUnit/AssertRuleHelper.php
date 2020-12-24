<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\PHPUnit;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
class AssertRuleHelper
{
    public static function isMethodOrStaticCallOnAssert(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : bool
    {
        $testCaseType = new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType('_PhpScoperb75b35f52b74\\PHPUnit\\Framework\\Assert');
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall) {
            $calledOnType = $scope->getType($node->var);
        } elseif ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall) {
            if ($node->class instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Name) {
                $class = (string) $node->class;
                if ($scope->isInClass() && \in_array(\strtolower($class), ['self', 'static', 'parent'], \true)) {
                    $calledOnType = new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($scope->getClassReflection()->getName());
                } else {
                    $calledOnType = new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($class);
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
