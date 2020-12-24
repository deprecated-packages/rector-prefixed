<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NodeNestingScope\ValueObject;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Match_;
use _PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Case_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Catch_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Do_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Else_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ElseIf_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\For_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Foreach_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Switch_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\While_;
final class ControlStructure
{
    /**
     * @var class-string[]
     */
    public const BREAKING_SCOPE_NODE_TYPES = [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\For_::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Foreach_::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\While_::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Do_::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Else_::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ElseIf_::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Catch_::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Case_::class, \_PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike::class];
    /**
     * These situations happens only if condition is met
     * @var class-string[]
     */
    public const CONDITIONAL_NODE_SCOPE_TYPES = [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\While_::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Do_::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Else_::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ElseIf_::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Catch_::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Case_::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Match_::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Switch_::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Foreach_::class];
}
