<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\Contract\NodeNameResolverInterface;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
final class FunctionNameResolver implements \_PhpScopere8e811afab72\Rector\NodeNameResolver\Contract\NodeNameResolverInterface
{
    public function getNode() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_::class;
    }
    /**
     * @param Function_ $node
     */
    public function resolve(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?string
    {
        $bareName = (string) $node->name;
        $namespaceName = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::NAMESPACE_NAME);
        if ($namespaceName) {
            return $namespaceName . '\\' . $bareName;
        }
        return $bareName;
    }
}
