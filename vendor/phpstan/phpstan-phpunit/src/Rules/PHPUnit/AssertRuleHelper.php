<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Rules\PHPUnit;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType;
class AssertRuleHelper
{
    public static function isMethodOrStaticCallOnAssert(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : bool
    {
        $testCaseType = new \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType('_PhpScoper0a2ac50786fa\\PHPUnit\\Framework\\Assert');
        if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall) {
            $calledOnType = $scope->getType($node->var);
        } elseif ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall) {
            if ($node->class instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Name) {
                $class = (string) $node->class;
                if ($scope->isInClass() && \in_array(\strtolower($class), ['self', 'static', 'parent'], \true)) {
                    $calledOnType = new \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType($scope->getClassReflection()->getName());
                } else {
                    $calledOnType = new \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType($class);
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
