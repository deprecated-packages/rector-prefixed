<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\PHPUnit;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
class AssertRuleHelper
{
    public static function isMethodOrStaticCallOnAssert(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : bool
    {
        $testCaseType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType('_PhpScoper0a6b37af0871\\PHPUnit\\Framework\\Assert');
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall) {
            $calledOnType = $scope->getType($node->var);
        } elseif ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall) {
            if ($node->class instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Name) {
                $class = (string) $node->class;
                if ($scope->isInClass() && \in_array(\strtolower($class), ['self', 'static', 'parent'], \true)) {
                    $calledOnType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType($scope->getClassReflection()->getName());
                } else {
                    $calledOnType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType($class);
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
