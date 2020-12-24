<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\PHPUnit;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Type\NullType;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\NodeAbstract>
 */
class AssertSameNullExpectedRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\NodeAbstract::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        if (!\_PhpScopere8e811afab72\PHPStan\Rules\PHPUnit\AssertRuleHelper::isMethodOrStaticCallOnAssert($node, $scope)) {
            return [];
        }
        /** @var \PhpParser\Node\Expr\MethodCall|\PhpParser\Node\Expr\StaticCall $node */
        $node = $node;
        if (\count($node->args) < 2) {
            return [];
        }
        if (!$node->name instanceof \_PhpScopere8e811afab72\PhpParser\Node\Identifier || \strtolower($node->name->name) !== 'assertsame') {
            return [];
        }
        $leftType = $scope->getType($node->args[0]->value);
        if ($leftType instanceof \_PhpScopere8e811afab72\PHPStan\Type\NullType) {
            return ['You should use assertNull() instead of assertSame(null, $actual).'];
        }
        return [];
    }
}
