<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\TypeInferer;

use PhpParser\Node\Expr\Closure;
use PhpParser\Node\FunctionLike;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Function_;
use PhpParser\Node\Stmt\Return_;
use PhpParser\Node\Stmt\Switch_;
use PhpParser\Node\Stmt\Throw_;
use PhpParser\Node\Stmt\TryCatch;
final class SilentVoidResolver
{
    /**
     * @param ClassMethod|Closure|Function_ $functionLike
     */
    public function hasSilentVoid(\PhpParser\Node\FunctionLike $functionLike) : bool
    {
        if ($this->hasStmtsAlwaysReturn((array) $functionLike->stmts)) {
            return \false;
        }
        foreach ((array) $functionLike->stmts as $stmt) {
            // has switch with always return
            if ($stmt instanceof \PhpParser\Node\Stmt\Switch_ && $this->isSwitchWithAlwaysReturn($stmt)) {
                return \false;
            }
            // is part of try/catch
            if ($stmt instanceof \PhpParser\Node\Stmt\TryCatch && $this->isTryCatchAlwaysReturn($stmt)) {
                return \false;
            }
            if ($stmt instanceof \PhpParser\Node\Stmt\Throw_) {
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
            if ($stmt instanceof \PhpParser\Node\Stmt\Expression) {
                $stmt = $stmt->expr;
            }
            // is 1st level return
            if ($stmt instanceof \PhpParser\Node\Stmt\Return_) {
                return \true;
            }
        }
        return \false;
    }
    private function isSwitchWithAlwaysReturn(\PhpParser\Node\Stmt\Switch_ $switch) : bool
    {
        $casesWithReturn = 0;
        foreach ($switch->cases as $case) {
            foreach ($case->stmts as $caseStmt) {
                if ($caseStmt instanceof \PhpParser\Node\Stmt\Return_) {
                    ++$casesWithReturn;
                    break;
                }
            }
        }
        // has same amount of returns as switches
        return \count((array) $switch->cases) === $casesWithReturn;
    }
    private function isTryCatchAlwaysReturn(\PhpParser\Node\Stmt\TryCatch $tryCatch) : bool
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
