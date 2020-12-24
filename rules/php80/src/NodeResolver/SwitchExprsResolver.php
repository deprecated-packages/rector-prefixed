<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Php80\NodeResolver;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Return_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Switch_;
use _PhpScoper2a4e7ab1ecbc\Rector\Php80\ValueObject\CondAndExpr;
final class SwitchExprsResolver
{
    /**
     * @return CondAndExpr[]
     */
    public function resolve(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Switch_ $switch) : array
    {
        $condAndExpr = [];
        foreach ($switch->cases as $case) {
            if (!isset($case->stmts[0])) {
                return [];
            }
            $expr = $case->stmts[0];
            if ($expr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression) {
                $expr = $expr->expr;
            }
            if ($expr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Return_) {
                $returnedExpr = $expr->expr;
                if ($returnedExpr === null) {
                    return [];
                }
                $condAndExpr[] = new \_PhpScoper2a4e7ab1ecbc\Rector\Php80\ValueObject\CondAndExpr($case->cond, $returnedExpr, \_PhpScoper2a4e7ab1ecbc\Rector\Php80\ValueObject\CondAndExpr::TYPE_RETURN);
            } elseif ($expr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign) {
                $condAndExpr[] = new \_PhpScoper2a4e7ab1ecbc\Rector\Php80\ValueObject\CondAndExpr($case->cond, $expr, \_PhpScoper2a4e7ab1ecbc\Rector\Php80\ValueObject\CondAndExpr::TYPE_ASSIGN);
            } elseif ($expr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr) {
                $condAndExpr[] = new \_PhpScoper2a4e7ab1ecbc\Rector\Php80\ValueObject\CondAndExpr($case->cond, $expr, \_PhpScoper2a4e7ab1ecbc\Rector\Php80\ValueObject\CondAndExpr::TYPE_NORMAL);
            } else {
                return [];
            }
        }
        return $condAndExpr;
    }
}
