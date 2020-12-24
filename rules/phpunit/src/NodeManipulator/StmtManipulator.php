<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PHPUnit\NodeManipulator;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
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
            if ($stmt instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression) {
                $normalizedStmts[] = $stmt;
                continue;
            }
            $normalizedStmts[] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression($stmt);
        }
        return $normalizedStmts;
    }
}
