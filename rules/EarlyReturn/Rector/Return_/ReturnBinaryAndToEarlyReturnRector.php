<?php

declare (strict_types=1);
namespace Rector\EarlyReturn\Rector\Return_;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use PhpParser\Node\Stmt\If_;
use PhpParser\Node\Stmt\Return_;
use Rector\Core\NodeAnalyzer\CallAnalyzer;
use Rector\Core\NodeManipulator\IfManipulator;
use Rector\Core\PhpParser\Node\AssignAndBinaryMap;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Tests\EarlyReturn\Rector\Return_\ReturnBinaryAndToEarlyReturnRector\ReturnBinaryAndToEarlyReturnRectorTest
 */
final class ReturnBinaryAndToEarlyReturnRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var IfManipulator
     */
    private $ifManipulator;
    /**
     * @var AssignAndBinaryMap
     */
    private $assignAndBinaryMap;
    /**
     * @var CallAnalyzer
     */
    private $callAnalyzer;
    /**
     * @param \Rector\Core\NodeManipulator\IfManipulator $ifManipulator
     * @param \Rector\Core\PhpParser\Node\AssignAndBinaryMap $assignAndBinaryMap
     * @param \Rector\Core\NodeAnalyzer\CallAnalyzer $callAnalyzer
     */
    public function __construct($ifManipulator, $assignAndBinaryMap, $callAnalyzer)
    {
        $this->ifManipulator = $ifManipulator;
        $this->assignAndBinaryMap = $assignAndBinaryMap;
        $this->callAnalyzer = $callAnalyzer;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes Single return of && to early returns', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function accept()
    {
        return $this->something() && $this->somethingelse();
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function accept()
    {
        if (!$this->something()) {
            return false;
        }
        return (bool) $this->somethingelse();
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\Return_::class];
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function refactor($node) : ?\PhpParser\Node
    {
        if (!$node->expr instanceof \PhpParser\Node\Expr\BinaryOp\BooleanAnd) {
            return null;
        }
        $left = $node->expr->left;
        $ifNegations = $this->createMultipleIfsNegation($left, $node, []);
        $this->mirrorComments($ifNegations[0], $node);
        foreach ($ifNegations as $ifNegation) {
            if (!$this->callAnalyzer->isObjectCall($ifNegation->cond)) {
                return null;
            }
            $this->addNodeBeforeNode($ifNegation, $node);
        }
        $lastReturnExpr = $this->assignAndBinaryMap->getTruthyExpr($node->expr->right);
        $this->addNodeBeforeNode(new \PhpParser\Node\Stmt\Return_($lastReturnExpr), $node);
        $this->removeNode($node);
        return $node;
    }
    /**
     * @param If_[] $ifNegations
     * @return If_[]
     * @param \PhpParser\Node\Expr $expr
     * @param \PhpParser\Node\Stmt\Return_ $return
     */
    private function createMultipleIfsNegation($expr, $return, $ifNegations) : array
    {
        while ($expr instanceof \PhpParser\Node\Expr\BinaryOp\BooleanAnd) {
            $ifNegations = \array_merge($ifNegations, $this->collectLeftBooleanAndToIfs($expr, $return, $ifNegations));
            $ifNegations[] = $this->ifManipulator->createIfNegation($expr->right, new \PhpParser\Node\Stmt\Return_($this->nodeFactory->createFalse()));
            $expr = $expr->right;
        }
        return $ifNegations + [$this->ifManipulator->createIfNegation($expr, new \PhpParser\Node\Stmt\Return_($this->nodeFactory->createFalse()))];
    }
    /**
     * @param If_[] $ifNegations
     * @return If_[]
     * @param \PhpParser\Node\Expr\BinaryOp\BooleanAnd $booleanAnd
     * @param \PhpParser\Node\Stmt\Return_ $return
     */
    private function collectLeftBooleanAndToIfs($booleanAnd, $return, $ifNegations) : array
    {
        $left = $booleanAnd->left;
        if (!$left instanceof \PhpParser\Node\Expr\BinaryOp\BooleanAnd) {
            return [$this->ifManipulator->createIfNegation($left, new \PhpParser\Node\Stmt\Return_($this->nodeFactory->createFalse()))];
        }
        return $this->createMultipleIfsNegation($left, $return, $ifNegations);
    }
}
