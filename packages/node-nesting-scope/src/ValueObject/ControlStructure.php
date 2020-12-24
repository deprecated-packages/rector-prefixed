<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeNestingScope\ValueObject;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\Match_;
use _PhpScopere8e811afab72\PhpParser\Node\FunctionLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Case_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Catch_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Do_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Else_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ElseIf_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\For_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Foreach_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\If_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Switch_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\While_;
final class ControlStructure
{
    /**
     * @var class-string[]
     */
    public const BREAKING_SCOPE_NODE_TYPES = [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\For_::class, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Foreach_::class, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\If_::class, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\While_::class, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Do_::class, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Else_::class, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ElseIf_::class, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Catch_::class, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Case_::class, \_PhpScopere8e811afab72\PhpParser\Node\FunctionLike::class];
    /**
     * These situations happens only if condition is met
     * @var class-string[]
     */
    public const CONDITIONAL_NODE_SCOPE_TYPES = [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\If_::class, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\While_::class, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Do_::class, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Else_::class, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ElseIf_::class, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Catch_::class, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Case_::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\Match_::class, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Switch_::class, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Foreach_::class];
}
