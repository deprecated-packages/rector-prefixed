<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\EarlyReturn\Rector\If_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Else_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\If_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\IfManipulator;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\StmtsManipulator;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://engineering.helpscout.com/reducing-complexity-with-guard-clauses-in-php-and-javascript-74600fd865c7
 *
 * @see \Rector\EarlyReturn\Tests\Rector\If_\ChangeIfElseValueAssignToEarlyReturnRector\ChangeIfElseValueAssignToEarlyReturnRectorTest
 */
final class ChangeIfElseValueAssignToEarlyReturnRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var IfManipulator
     */
    private $ifManipulator;
    /**
     * @var StmtsManipulator
     */
    private $stmtsManipulator;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\IfManipulator $ifManipulator, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\StmtsManipulator $stmtsManipulator)
    {
        $this->ifManipulator = $ifManipulator;
        $this->stmtsManipulator = $stmtsManipulator;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change if/else value to early return', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        if ($this->hasDocBlock($tokens, $index)) {
            $docToken = $tokens[$this->getDocBlockIndex($tokens, $index)];
        } else {
            $docToken = null;
        }

        return $docToken;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        if ($this->hasDocBlock($tokens, $index)) {
            return $tokens[$this->getDocBlockIndex($tokens, $index)];
        }
        return null;
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
        $nextNode = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        if (!$nextNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_) {
            return null;
        }
        if ($nextNode->expr === null) {
            return null;
        }
        if (!$this->ifManipulator->isIfAndElseWithSameVariableAssignAsLastStmts($node, $nextNode->expr)) {
            return null;
        }
        $lastIfStmtKey = \array_key_last($node->stmts);
        /** @var Assign $assign */
        $assign = $this->stmtsManipulator->getUnwrappedLastStmt($node->stmts);
        $return = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_($assign->expr);
        $this->mirrorComments($return, $assign);
        $node->stmts[$lastIfStmtKey] = $return;
        $else = $node->else;
        if (!$else instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Else_) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        $elseStmts = (array) $else->stmts;
        /** @var Assign $assign */
        $assign = $this->stmtsManipulator->getUnwrappedLastStmt($elseStmts);
        $lastElseStmtKey = \array_key_last($elseStmts);
        $return = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_($assign->expr);
        $this->mirrorComments($return, $assign);
        $elseStmts[$lastElseStmtKey] = $return;
        $node->else = null;
        $this->addNodesAfterNode($elseStmts, $node);
        $this->removeNode($nextNode);
        return $node;
    }
}
