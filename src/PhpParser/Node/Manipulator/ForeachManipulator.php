<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Foreach_;
final class ForeachManipulator
{
    public function matchOnlyStmt(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Foreach_ $foreach, callable $callable) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $stmts = (array) $foreach->stmts;
        if (\count($stmts) !== 1) {
            return null;
        }
        $innerNode = $stmts[0];
        $innerNode = $innerNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression ? $innerNode->expr : $innerNode;
        return $callable($innerNode, $foreach);
    }
}
