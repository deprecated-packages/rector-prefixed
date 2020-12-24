<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Empty_;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\Contract\NodeNameResolverInterface;
final class EmptyNameResolver implements \_PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\Contract\NodeNameResolverInterface
{
    public function getNode() : string
    {
        return \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Empty_::class;
    }
    /**
     * @param Empty_ $node
     */
    public function resolve(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?string
    {
        return 'empty';
    }
}
