<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DeadCode\Rector\If_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\If_;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DeadCode\Tests\Rector\If_\SimplifyIfElseWithSameContentRector\SimplifyIfElseWithSameContentRectorTest
 */
final class SimplifyIfElseWithSameContentRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove if/else if they have same content', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        if (true) {
            return 1;
        } else {
            return 1;
        }
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        return 1;
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\If_::class];
    }
    /**
     * @param If_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($node->else === null) {
            return null;
        }
        if (!$this->isIfWithConstantReturns($node)) {
            return null;
        }
        foreach ($node->stmts as $stmt) {
            $this->addNodeBeforeNode($stmt, $node);
        }
        $this->removeNode($node);
        return $node;
    }
    private function isIfWithConstantReturns(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\If_ $if) : bool
    {
        $possibleContents = [];
        $possibleContents[] = $this->print($if->stmts);
        foreach ($if->elseifs as $elseif) {
            $possibleContents[] = $this->print($elseif->stmts);
        }
        $else = $if->else;
        if ($else === null) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        $possibleContents[] = $this->print($else->stmts);
        $uniqueContents = \array_unique($possibleContents);
        // only one content for all
        return \count($uniqueContents) === 1;
    }
}
