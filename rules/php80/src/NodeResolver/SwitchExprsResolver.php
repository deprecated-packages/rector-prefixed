<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Php80\NodeResolver;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Switch_;
use _PhpScoper0a6b37af0871\Rector\Php80\ValueObject\CondAndExpr;
final class SwitchExprsResolver
{
    /**
     * @return CondAndExpr[]
     */
    public function resolve(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Switch_ $switch) : array
    {
        $condAndExpr = [];
        foreach ($switch->cases as $case) {
            if (!isset($case->stmts[0])) {
                return [];
            }
            $expr = $case->stmts[0];
            if ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression) {
                $expr = $expr->expr;
            }
            if ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_) {
                $returnedExpr = $expr->expr;
                if ($returnedExpr === null) {
                    return [];
                }
                $condAndExpr[] = new \_PhpScoper0a6b37af0871\Rector\Php80\ValueObject\CondAndExpr($case->cond, $returnedExpr, \_PhpScoper0a6b37af0871\Rector\Php80\ValueObject\CondAndExpr::TYPE_RETURN);
            } elseif ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign) {
                $condAndExpr[] = new \_PhpScoper0a6b37af0871\Rector\Php80\ValueObject\CondAndExpr($case->cond, $expr, \_PhpScoper0a6b37af0871\Rector\Php80\ValueObject\CondAndExpr::TYPE_ASSIGN);
            } elseif ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr) {
                $condAndExpr[] = new \_PhpScoper0a6b37af0871\Rector\Php80\ValueObject\CondAndExpr($case->cond, $expr, \_PhpScoper0a6b37af0871\Rector\Php80\ValueObject\CondAndExpr::TYPE_NORMAL);
            } else {
                return [];
            }
        }
        return $condAndExpr;
    }
}
