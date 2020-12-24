<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Php80\NodeAnalyzer;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Break_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Switch_;
final class SwitchAnalyzer
{
    public function hasEachCaseBreak(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Switch_ $switch) : bool
    {
        foreach ($switch->cases as $case) {
            foreach ($case->stmts as $caseStmt) {
                if (!$caseStmt instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Break_) {
                    continue;
                }
                return \true;
            }
        }
        return \false;
    }
    public function hasEachCaseSingleStmt(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Switch_ $switch) : bool
    {
        foreach ($switch->cases as $case) {
            $stmtsWithoutBreak = \array_filter($case->stmts, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) : bool {
                return !$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Break_;
            });
            if (\count($stmtsWithoutBreak) !== 1) {
                return \false;
            }
        }
        return \true;
    }
}
