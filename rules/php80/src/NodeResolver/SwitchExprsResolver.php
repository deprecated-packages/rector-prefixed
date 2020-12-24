<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Php80\NodeResolver;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Switch_;
use _PhpScoperb75b35f52b74\Rector\Php80\ValueObject\CondAndExpr;
final class SwitchExprsResolver
{
    /**
     * @return CondAndExpr[]
     */
    public function resolve(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Switch_ $switch) : array
    {
        $condAndExpr = [];
        foreach ($switch->cases as $case) {
            if (!isset($case->stmts[0])) {
                return [];
            }
            $expr = $case->stmts[0];
            if ($expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression) {
                $expr = $expr->expr;
            }
            if ($expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_) {
                $returnedExpr = $expr->expr;
                if ($returnedExpr === null) {
                    return [];
                }
                $condAndExpr[] = new \_PhpScoperb75b35f52b74\Rector\Php80\ValueObject\CondAndExpr($case->cond, $returnedExpr, \_PhpScoperb75b35f52b74\Rector\Php80\ValueObject\CondAndExpr::TYPE_RETURN);
            } elseif ($expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
                $condAndExpr[] = new \_PhpScoperb75b35f52b74\Rector\Php80\ValueObject\CondAndExpr($case->cond, $expr, \_PhpScoperb75b35f52b74\Rector\Php80\ValueObject\CondAndExpr::TYPE_ASSIGN);
            } elseif ($expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr) {
                $condAndExpr[] = new \_PhpScoperb75b35f52b74\Rector\Php80\ValueObject\CondAndExpr($case->cond, $expr, \_PhpScoperb75b35f52b74\Rector\Php80\ValueObject\CondAndExpr::TYPE_NORMAL);
            } else {
                return [];
            }
        }
        return $condAndExpr;
    }
}
