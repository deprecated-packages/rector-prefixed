<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassConst;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\Contract\NodeNameResolverInterface;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
final class ClassConstNameResolver implements \_PhpScopere8e811afab72\Rector\NodeNameResolver\Contract\NodeNameResolverInterface
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @required
     */
    public function autowireClassConstNameResolver(\_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver) : void
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function getNode() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassConst::class;
    }
    /**
     * @param ClassConst $node
     */
    public function resolve(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?string
    {
        if ($node->consts === []) {
            return null;
        }
        $onlyConstant = $node->consts[0];
        return $this->nodeNameResolver->getName($onlyConstant);
    }
}
