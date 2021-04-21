<?php

declare(strict_types=1);

namespace Rector\Naming\Matcher;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Stmt\Foreach_;

final class CallMatcher
{
    /**
     * @param Assign|Foreach_ $node
     * @return \PhpParser\Node|null
     */
    public function matchCall(Node $node)
    {
        if ($node->expr instanceof MethodCall) {
            return $node->expr;
        }

        if ($node->expr instanceof StaticCall) {
            return $node->expr;
        }

        if ($node->expr instanceof FuncCall) {
            return $node->expr;
        }

        return null;
    }
}
