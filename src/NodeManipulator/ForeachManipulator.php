<?php

declare(strict_types=1);

namespace Rector\Core\NodeManipulator;

use PhpParser\Node;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Foreach_;

final class ForeachManipulator
{
    /**
     * @return \PhpParser\Node|null
     */
    public function matchOnlyStmt(Foreach_ $foreach, callable $callable)
    {
        $stmts = $foreach->stmts;

        if (count($stmts) !== 1) {
            return null;
        }

        $innerNode = $stmts[0];
        $innerNode = $innerNode instanceof Expression ? $innerNode->expr : $innerNode;

        return $callable($innerNode, $foreach);
    }
}
