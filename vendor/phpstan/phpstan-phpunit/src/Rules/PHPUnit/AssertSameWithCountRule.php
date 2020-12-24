<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\PHPUnit;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\NodeAbstract>
 */
class AssertSameWithCountRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
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
        $right = $node->args[1]->value;
        if ($right instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall && $right->name instanceof \_PhpScopere8e811afab72\PhpParser\Node\Name && \strtolower($right->name->toString()) === 'count') {
            return ['You should use assertCount($expectedCount, $variable) instead of assertSame($expectedCount, count($variable)).'];
        }
        if ($right instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall && $right->name instanceof \_PhpScopere8e811afab72\PhpParser\Node\Identifier && \strtolower($right->name->toString()) === 'count' && \count($right->args) === 0) {
            $type = $scope->getType($right->var);
            if ((new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType(\Countable::class))->isSuperTypeOf($type)->yes()) {
                return ['You should use assertCount($expectedCount, $variable) instead of assertSame($expectedCount, $variable->count()).'];
            }
        }
        return [];
    }
}
