<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\Contract\NodeNameResolverInterface;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
final class ParamNameResolver implements \_PhpScopere8e811afab72\Rector\NodeNameResolver\Contract\NodeNameResolverInterface
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @required
     */
    public function autowireParamNameResolver(\_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver) : void
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function getNode() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Param::class;
    }
    /**
     * @param Param $node
     */
    public function resolve(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?string
    {
        return $this->nodeNameResolver->getName($node->var);
    }
}
