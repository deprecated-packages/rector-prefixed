<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodingStyle\Rector\Plus;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp\Minus;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp\Plus;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PreDec;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PreInc;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\LNumber;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodingStyle\Tests\Rector\Plus\UseIncrementAssignRector\UseIncrementAssignRectorTest
 */
final class UseIncrementAssignRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Use ++ increment instead of `$var += 1`', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $style += 1;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        ++$style;
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp\Plus::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp\Minus::class];
    }
    /**
     * @param Plus|Minus $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$node->expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\LNumber) {
            return null;
        }
        if ($node->expr->value !== 1) {
            return null;
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp\Plus) {
            return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\PreInc($node->var);
        }
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\PreDec($node->var);
    }
}
