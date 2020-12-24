<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\PHPUnit;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\NodeAbstract>
 */
class AssertSameWithCountRule implements \_PhpScoper0a6b37af0871\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PhpParser\NodeAbstract::class;
    }
    public function processNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : array
    {
        if (!\_PhpScoper0a6b37af0871\PHPStan\Rules\PHPUnit\AssertRuleHelper::isMethodOrStaticCallOnAssert($node, $scope)) {
            return [];
        }
        /** @var \PhpParser\Node\Expr\MethodCall|\PhpParser\Node\Expr\StaticCall $node */
        $node = $node;
        if (\count($node->args) < 2) {
            return [];
        }
        if (!$node->name instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Identifier || \strtolower($node->name->name) !== 'assertsame') {
            return [];
        }
        $right = $node->args[1]->value;
        if ($right instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall && $right->name instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Name && \strtolower($right->name->toString()) === 'count') {
            return ['You should use assertCount($expectedCount, $variable) instead of assertSame($expectedCount, count($variable)).'];
        }
        if ($right instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall && $right->name instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Identifier && \strtolower($right->name->toString()) === 'count' && \count($right->args) === 0) {
            $type = $scope->getType($right->var);
            if ((new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType(\Countable::class))->isSuperTypeOf($type)->yes()) {
                return ['You should use assertCount($expectedCount, $variable) instead of assertSame($expectedCount, $variable->count()).'];
            }
        }
        return [];
    }
}
