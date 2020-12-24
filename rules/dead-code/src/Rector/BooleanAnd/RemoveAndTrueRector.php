<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DeadCode\Rector\BooleanAnd;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DeadCode\Tests\Rector\BooleanAnd\RemoveAndTrueRector\RemoveAndTrueRectorTest
 */
final class RemoveAndTrueRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove and true that has no added value', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        return true && 5 === 1;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        return 5 === 1;
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\BooleanAnd::class];
    }
    /**
     * @param BooleanAnd $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($this->isTrueOrBooleanAndTrues($node->left)) {
            return $node->right;
        }
        if ($this->isTrueOrBooleanAndTrues($node->right)) {
            return $node->left;
        }
        return null;
    }
    private function isTrueOrBooleanAndTrues(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        if ($this->isTrue($node)) {
            return \true;
        }
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\BooleanAnd) {
            return \false;
        }
        if (!$this->isTrueOrBooleanAndTrues($node->left)) {
            return \false;
        }
        return $this->isTrueOrBooleanAndTrues($node->right);
    }
}
