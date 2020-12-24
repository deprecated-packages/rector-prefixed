<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Foreach_;
final class ForeachManipulator
{
    public function matchOnlyStmt(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Foreach_ $foreach, callable $callable) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $stmts = (array) $foreach->stmts;
        if (\count($stmts) !== 1) {
            return null;
        }
        $innerNode = $stmts[0];
        $innerNode = $innerNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression ? $innerNode->expr : $innerNode;
        return $callable($innerNode, $foreach);
    }
}
