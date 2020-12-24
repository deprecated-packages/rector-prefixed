<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Use_;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\Contract\NodeNameResolverInterface;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
final class UseNameResolver implements \_PhpScopere8e811afab72\Rector\NodeNameResolver\Contract\NodeNameResolverInterface
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @required
     */
    public function autowireUseNameResolver(\_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver) : void
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function getNode() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Use_::class;
    }
    /**
     * @param Use_ $node
     */
    public function resolve(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?string
    {
        if ($node->uses === []) {
            return null;
        }
        $onlyUse = $node->uses[0];
        return $this->nodeNameResolver->getName($onlyUse);
    }
}
