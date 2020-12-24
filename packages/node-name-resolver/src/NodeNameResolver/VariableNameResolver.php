<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\Contract\NodeNameResolverInterface;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
final class VariableNameResolver implements \_PhpScopere8e811afab72\Rector\NodeNameResolver\Contract\NodeNameResolverInterface
{
    public function getNode() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable::class;
    }
    /**
     * @param Variable $node
     */
    public function resolve(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?string
    {
        $parentNode = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        // skip $some->$dynamicMethodName()
        if ($parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall && $node === $parentNode->name) {
            return null;
        }
        // skip $some->$dynamicPropertyName
        if ($parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch && $node === $parentNode->name) {
            return null;
        }
        if ($node->name instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr) {
            return null;
        }
        return (string) $node->name;
    }
}
