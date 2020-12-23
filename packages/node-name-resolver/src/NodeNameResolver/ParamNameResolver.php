<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Param;
use _PhpScoper0a2ac50786fa\Rector\NodeNameResolver\Contract\NodeNameResolverInterface;
use _PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver;
final class ParamNameResolver implements \_PhpScoper0a2ac50786fa\Rector\NodeNameResolver\Contract\NodeNameResolverInterface
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @required
     */
    public function autowireParamNameResolver(\_PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver) : void
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function getNode() : string
    {
        return \_PhpScoper0a2ac50786fa\PhpParser\Node\Param::class;
    }
    /**
     * @param Param $node
     */
    public function resolve(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?string
    {
        return $this->nodeNameResolver->getName($node->var);
    }
}
