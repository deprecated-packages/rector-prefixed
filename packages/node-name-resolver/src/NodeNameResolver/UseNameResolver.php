<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Use_;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\Contract\NodeNameResolverInterface;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
final class UseNameResolver implements \_PhpScoperb75b35f52b74\Rector\NodeNameResolver\Contract\NodeNameResolverInterface
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @required
     */
    public function autowireUseNameResolver(\_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver) : void
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function getNode() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Use_::class;
    }
    /**
     * @param Use_ $node
     */
    public function resolve(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?string
    {
        if ($node->uses === []) {
            return null;
        }
        $onlyUse = $node->uses[0];
        return $this->nodeNameResolver->getName($onlyUse);
    }
}
