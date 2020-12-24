<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PHPUnit\NodeManipulator;

use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
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
            if ($stmt instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression) {
                $normalizedStmts[] = $stmt;
                continue;
            }
            $normalizedStmts[] = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression($stmt);
        }
        return $normalizedStmts;
    }
}
