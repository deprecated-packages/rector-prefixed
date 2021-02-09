<?php

declare (strict_types=1);
namespace Rector\EarlyReturn\Rector\Return_;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use PhpParser\Node\Expr\BooleanNot;
use PhpParser\Node\Expr\Cast\Bool_;
use PhpParser\Node\Stmt\If_;
use PhpParser\Node\Stmt\Return_;
use PHPStan\Analyser\Scope;
use PHPStan\Type\BooleanType;
use Rector\Core\NodeManipulator\IfManipulator;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\EarlyReturn\Tests\Rector\Return_\ReturnBinaryAndToEarlyReturnRector\ReturnBinaryAndToEarlyReturnRectorTest
 */
final class ReturnBinaryAndToEarlyReturnRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var IfManipulator
     */
    private $ifManipulator;
    public function __construct(\Rector\Core\NodeManipulator\IfManipulator $ifManipulator)
    {
        $this->ifManipulator = $ifManipulator;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes Single return of && && to early returns', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function accept($something, $somethingelse)
    {
        return $something && $somethingelse;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function accept($something, $somethingelse)
    {
        if (!$something) {
            return false;
        }
        return (bool) $somethingelse;
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
        return [\PhpParser\Node\Stmt\Return_::class];
    }
    /**
     * @param Return_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$node->expr instanceof \PhpParser\Node\Expr\BinaryOp\BooleanAnd) {
            return null;
        }
        $left = $node->expr->left;
        $ifNegations = $this->createMultipleIfsNegation($left, $node, []);
        foreach ($ifNegations as $key => $ifNegation) {
            if ($key === 0) {
                $this->mirrorComments($ifNegation, $node);
            }
            $this->addNodeBeforeNode($ifNegation, $node);
        }
        $lastReturnExpr = $this->getLastReturnExpr($node->expr->right);
        $this->addNodeBeforeNode(new \PhpParser\Node\Stmt\Return_($lastReturnExpr), $node);
        $this->removeNode($node);
        return $node;
    }
    /**
     * @param If_[] $ifNegations
     * @return If_[]
     */
    private function createMultipleIfsNegation(\PhpParser\Node\Expr $expr, \PhpParser\Node\Stmt\Return_ $return, array $ifNegations) : array
    {
        while ($expr instanceof \PhpParser\Node\Expr\BinaryOp\BooleanAnd) {
            $ifNegations = \array_merge($ifNegations, $this->collectLeftBooleanAndToIfs($expr, $return, $ifNegations));
            $ifNegations[] = $this->ifManipulator->createIfNegation($expr->right, new \PhpParser\Node\Stmt\Return_($this->nodeFactory->createFalse()));
            $expr = $expr->right;
        }
        return $ifNegations + [$this->ifManipulator->createIfNegation($expr, new \PhpParser\Node\Stmt\Return_($this->nodeFactory->createFalse()))];
    }
    private function getLastReturnExpr(\PhpParser\Node\Expr $expr) : \PhpParser\Node\Expr
    {
        if ($expr instanceof \PhpParser\Node\Expr\Cast\Bool_) {
            return $expr;
        }
        if ($expr instanceof \PhpParser\Node\Expr\BooleanNot) {
            return $expr;
        }
        $scope = $expr->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if (!$scope instanceof \PHPStan\Analyser\Scope) {
            return new \PhpParser\Node\Expr\Cast\Bool_($expr);
        }
        $type = $scope->getType($expr);
        if ($type instanceof \PHPStan\Type\BooleanType) {
            return $expr;
        }
        return new \PhpParser\Node\Expr\Cast\Bool_($expr);
    }
    /**
     * @param If_[] $ifNegations
     * @return If_[]
     */
    private function collectLeftBooleanAndToIfs(\PhpParser\Node\Expr\BinaryOp\BooleanAnd $booleanAnd, \PhpParser\Node\Stmt\Return_ $return, array $ifNegations) : array
    {
        $left = $booleanAnd->left;
        if (!$left instanceof \PhpParser\Node\Expr\BinaryOp\BooleanAnd) {
            return [$this->ifManipulator->createIfNegation($left, new \PhpParser\Node\Stmt\Return_($this->nodeFactory->createFalse()))];
        }
        return $this->createMultipleIfsNegation($left, $return, $ifNegations);
    }
}
