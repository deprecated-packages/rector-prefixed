<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DeadCode\Rector\Switch_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Break_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Case_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Switch_;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DeadCode\Tests\Rector\Switch_\RemoveDuplicatedCaseInSwitchRector\RemoveDuplicatedCaseInSwitchRectorTest
 */
final class RemoveDuplicatedCaseInSwitchRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('2 following switch keys with identical  will be reduced to one result', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        switch ($name) {
             case 'clearHeader':
                 return $this->modifyHeader($node, 'remove');
             case 'clearAllHeaders':
                 return $this->modifyHeader($node, 'replace');
             case 'clearRawHeaders':
                 return $this->modifyHeader($node, 'replace');
             case '...':
                 return 5;
        }
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        switch ($name) {
             case 'clearHeader':
                 return $this->modifyHeader($node, 'remove');
             case 'clearAllHeaders':
             case 'clearRawHeaders':
                 return $this->modifyHeader($node, 'replace');
             case '...':
                 return 5;
        }
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Switch_::class];
    }
    /**
     * @param Switch_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (\count((array) $node->cases) < 2) {
            return null;
        }
        /** @var Case_|null $previousCase */
        $previousCase = null;
        foreach ($node->cases as $case) {
            if ($previousCase && $this->areSwitchStmtsEqualsAndWithBreak($case, $previousCase)) {
                $previousCase->stmts = [];
            }
            $previousCase = $case;
        }
        return $node;
    }
    private function areSwitchStmtsEqualsAndWithBreak(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Case_ $currentCase, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Case_ $previousCase) : bool
    {
        if (!$this->areNodesEqual($currentCase->stmts, $previousCase->stmts)) {
            return \false;
        }
        foreach ($currentCase->stmts as $stmt) {
            if ($stmt instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Break_) {
                return \true;
            }
            if ($stmt instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_) {
                return \true;
            }
        }
        return \false;
    }
}
