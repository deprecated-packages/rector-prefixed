<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\TypeInferer;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Closure;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\FunctionLike;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Function_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Return_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Switch_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Throw_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\TryCatch;
final class SilentVoidResolver
{
    /**
     * @param ClassMethod|Closure|Function_ $functionLike
     */
    public function hasSilentVoid(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\FunctionLike $functionLike) : bool
    {
        if ($this->hasStmtsAlwaysReturn((array) $functionLike->stmts)) {
            return \false;
        }
        foreach ((array) $functionLike->stmts as $stmt) {
            // has switch with always return
            if ($stmt instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Switch_ && $this->isSwitchWithAlwaysReturn($stmt)) {
                return \false;
            }
            // is part of try/catch
            if ($stmt instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\TryCatch && $this->isTryCatchAlwaysReturn($stmt)) {
                return \false;
            }
            if ($stmt instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Throw_) {
                return \false;
            }
        }
        return \true;
    }
    /**
     * @param Stmt[]|Expression[] $stmts
     */
    private function hasStmtsAlwaysReturn(array $stmts) : bool
    {
        foreach ($stmts as $stmt) {
            if ($stmt instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression) {
                $stmt = $stmt->expr;
            }
            // is 1st level return
            if ($stmt instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Return_) {
                return \true;
            }
        }
        return \false;
    }
    private function isSwitchWithAlwaysReturn(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Switch_ $switch) : bool
    {
        $casesWithReturn = 0;
        foreach ($switch->cases as $case) {
            foreach ($case->stmts as $caseStmt) {
                if ($caseStmt instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Return_) {
                    ++$casesWithReturn;
                    break;
                }
            }
        }
        // has same amount of returns as switches
        return \count((array) $switch->cases) === $casesWithReturn;
    }
    private function isTryCatchAlwaysReturn(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\TryCatch $tryCatch) : bool
    {
        if (!$this->hasStmtsAlwaysReturn($tryCatch->stmts)) {
            return \false;
        }
        foreach ($tryCatch->catches as $catch) {
            return $this->hasStmtsAlwaysReturn((array) $catch->stmts);
        }
        return \true;
    }
}
