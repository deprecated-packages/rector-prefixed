<?php

declare (strict_types=1);
namespace RectorPrefix20210408\Symplify\Astral\NodeNameResolver;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\FuncCall;
use RectorPrefix20210408\Symplify\Astral\Contract\NodeNameResolverInterface;
final class FuncCallNodeNameResolver implements \RectorPrefix20210408\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\PhpParser\Node $node) : bool
    {
        return $node instanceof \PhpParser\Node\Expr\FuncCall;
    }
    /**
     * @param FuncCall $node
     */
    public function resolve(\PhpParser\Node $node) : ?string
    {
        if ($node->name instanceof \PhpParser\Node\Expr) {
            return null;
        }
        return (string) $node->name;
    }
}
