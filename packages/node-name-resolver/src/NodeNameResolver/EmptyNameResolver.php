<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Empty_;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\Contract\NodeNameResolverInterface;
final class EmptyNameResolver implements \_PhpScoperb75b35f52b74\Rector\NodeNameResolver\Contract\NodeNameResolverInterface
{
    public function getNode() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Empty_::class;
    }
    /**
     * @param Empty_ $node
     */
    public function resolve(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?string
    {
        return 'empty';
    }
}
