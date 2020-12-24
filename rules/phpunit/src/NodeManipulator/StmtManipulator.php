<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PHPUnit\NodeManipulator;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression;
final class StmtManipulator
{
    /**
     * @param Expr[]|Stmt[] $stmts
     * @return Stmt[]
     */
    public function normalizeStmts(array $stmts) : array
    {
        $normalizedStmts = [];
        foreach ($stmts as $stmt) {
            if ($stmt instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression) {
                $normalizedStmts[] = $stmt;
                continue;
            }
            $normalizedStmts[] = new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression($stmt);
        }
        return $normalizedStmts;
    }
}
