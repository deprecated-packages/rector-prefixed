<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Empty_;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\Contract\NodeNameResolverInterface;
final class EmptyNameResolver implements \_PhpScopere8e811afab72\Rector\NodeNameResolver\Contract\NodeNameResolverInterface
{
    public function getNode() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Expr\Empty_::class;
    }
    /**
     * @param Empty_ $node
     */
    public function resolve(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?string
    {
        return 'empty';
    }
}
