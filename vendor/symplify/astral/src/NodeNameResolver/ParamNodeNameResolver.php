<?php

declare (strict_types=1);
namespace RectorPrefix20210422\Symplify\Astral\NodeNameResolver;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Param;
use RectorPrefix20210422\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ParamNodeNameResolver implements \RectorPrefix20210422\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\PhpParser\Node $node) : bool
    {
        return $node instanceof \PhpParser\Node\Param;
    }
    /**
     * @param Param $node
     * @return string|null
     */
    public function resolve(\PhpParser\Node $node)
    {
        $paramName = $node->var->name;
        if ($paramName instanceof \PhpParser\Node\Expr) {
            return null;
        }
        return $paramName;
    }
}
