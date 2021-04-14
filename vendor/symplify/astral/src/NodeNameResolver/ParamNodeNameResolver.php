<?php

declare(strict_types=1);

namespace Symplify\Astral\NodeNameResolver;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Param;
use Symplify\Astral\Contract\NodeNameResolverInterface;

final class ParamNodeNameResolver implements NodeNameResolverInterface
{
    public function match(Node $node): bool
    {
        return $node instanceof Param;
    }

    /**
     * @param Param $node
     */
    public function resolve(Node $node): ?string
    {
        $paramName = $node->var->name;
        if ($paramName instanceof Expr) {
            return null;
        }

        return $paramName;
    }
}
