<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php80\NodeResolver;

use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Switch_;
use _PhpScopere8e811afab72\Rector\Php80\ValueObject\CondAndExpr;
final class SwitchExprsResolver
{
    /**
     * @return CondAndExpr[]
     */
    public function resolve(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Switch_ $switch) : array
    {
        $condAndExpr = [];
        foreach ($switch->cases as $case) {
            if (!isset($case->stmts[0])) {
                return [];
            }
            $expr = $case->stmts[0];
            if ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression) {
                $expr = $expr->expr;
            }
            if ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_) {
                $returnedExpr = $expr->expr;
                if ($returnedExpr === null) {
                    return [];
                }
                $condAndExpr[] = new \_PhpScopere8e811afab72\Rector\Php80\ValueObject\CondAndExpr($case->cond, $returnedExpr, \_PhpScopere8e811afab72\Rector\Php80\ValueObject\CondAndExpr::TYPE_RETURN);
            } elseif ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign) {
                $condAndExpr[] = new \_PhpScopere8e811afab72\Rector\Php80\ValueObject\CondAndExpr($case->cond, $expr, \_PhpScopere8e811afab72\Rector\Php80\ValueObject\CondAndExpr::TYPE_ASSIGN);
            } elseif ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr) {
                $condAndExpr[] = new \_PhpScopere8e811afab72\Rector\Php80\ValueObject\CondAndExpr($case->cond, $expr, \_PhpScopere8e811afab72\Rector\Php80\ValueObject\CondAndExpr::TYPE_NORMAL);
            } else {
                return [];
            }
        }
        return $condAndExpr;
    }
}
