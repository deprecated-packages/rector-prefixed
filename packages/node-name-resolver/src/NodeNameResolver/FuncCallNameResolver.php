<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\Contract\NodeNameResolverInterface;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
final class FuncCallNameResolver implements \_PhpScopere8e811afab72\Rector\NodeNameResolver\Contract\NodeNameResolverInterface
{
    public function getNode() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall::class;
    }
    /**
     * If some function is namespaced, it will be used over global one.
     * But only if it really exists.
     *
     * @param FuncCall $node
     */
    public function resolve(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?string
    {
        if ($node->name instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr) {
            return null;
        }
        $functionName = $node->name;
        if (!$functionName instanceof \_PhpScopere8e811afab72\PhpParser\Node\Name) {
            return (string) $functionName;
        }
        $namespaceName = $functionName->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::NAMESPACED_NAME);
        if ($namespaceName instanceof \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified) {
            $functionFqnName = $namespaceName->toString();
            if (\function_exists($functionFqnName)) {
                return $functionFqnName;
            }
        }
        return (string) $functionName;
    }
}
