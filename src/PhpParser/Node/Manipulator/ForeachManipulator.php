<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Foreach_;
final class ForeachManipulator
{
    public function matchOnlyStmt(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Foreach_ $foreach, callable $callable) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $stmts = (array) $foreach->stmts;
        if (\count($stmts) !== 1) {
            return null;
        }
        $innerNode = $stmts[0];
        $innerNode = $innerNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression ? $innerNode->expr : $innerNode;
        return $callable($innerNode, $foreach);
    }
}
