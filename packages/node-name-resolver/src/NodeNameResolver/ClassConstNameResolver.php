<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassConst;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\Contract\NodeNameResolverInterface;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
final class ClassConstNameResolver implements \_PhpScoper0a6b37af0871\Rector\NodeNameResolver\Contract\NodeNameResolverInterface
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @required
     */
    public function autowireClassConstNameResolver(\_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver) : void
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function getNode() : string
    {
        return \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassConst::class;
    }
    /**
     * @param ClassConst $node
     */
    public function resolve(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?string
    {
        if ($node->consts === []) {
            return null;
        }
        $onlyConstant = $node->consts[0];
        return $this->nodeNameResolver->getName($onlyConstant);
    }
}
