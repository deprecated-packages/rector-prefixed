<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\PHPUnit;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use PHPStan\Type\Constant\ConstantBooleanType;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\NodeAbstract>
 */
class AssertSameBooleanExpectedRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \PhpParser\NodeAbstract::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        if (!\RectorPrefix20201227\PHPStan\Rules\PHPUnit\AssertRuleHelper::isMethodOrStaticCallOnAssert($node, $scope)) {
            return [];
        }
        /** @var \PhpParser\Node\Expr\MethodCall|\PhpParser\Node\Expr\StaticCall $node */
        $node = $node;
        if (\count($node->args) < 2) {
            return [];
        }
        if (!$node->name instanceof \PhpParser\Node\Identifier || \strtolower($node->name->name) !== 'assertsame') {
            return [];
        }
        $leftType = $scope->getType($node->args[0]->value);
        if (!$leftType instanceof \PHPStan\Type\Constant\ConstantBooleanType) {
            return [];
        }
        if ($leftType->getValue()) {
            return ['You should use assertTrue() instead of assertSame() when expecting "true"'];
        }
        return ['You should use assertFalse() instead of assertSame() when expecting "false"'];
    }
}
