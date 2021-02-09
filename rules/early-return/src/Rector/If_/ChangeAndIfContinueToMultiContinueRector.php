<?php

declare (strict_types=1);
namespace Rector\EarlyReturn\Rector\If_;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use PhpParser\Node\Stmt\Continue_;
use PhpParser\Node\Stmt\If_;
use Rector\Core\NodeManipulator\IfManipulator;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\EarlyReturn\Tests\Rector\If_\ChangeAndIfContinueToMultiContinueRector\ChangeAndIfContinueToMultiContinueRectorTest
 */
final class ChangeAndIfContinueToMultiContinueRector extends \Rector\Core\Rector\AbstractRector
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
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes if && to early return', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function canDrive(Car $newCar)
    {
        foreach ($cars as $car) {
            if ($car->hasWheels() && $car->hasFuel()) {
                continue;
            }

            $car->setWheel($newCar->wheel);
            $car->setFuel($newCar->fuel);
        }
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function canDrive(Car $newCar)
    {
        foreach ($cars as $car) {
            if (! $car->hasWheels()) {
                continue;
            }
            if (! $car->hasFuel()) {
                continue;
            }

            $car->setWheel($newCar->wheel);
            $car->setFuel($newCar->fuel);
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
        return [\PhpParser\Node\Stmt\If_::class];
    }
    /**
     * @param If_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->ifManipulator->isIfWithOnly($node, \PhpParser\Node\Stmt\Continue_::class)) {
            return null;
        }
        if (!$node->cond instanceof \PhpParser\Node\Expr\BinaryOp\BooleanAnd) {
            return null;
        }
        return $this->processMultiIfContinue($node);
    }
    private function processMultiIfContinue(\PhpParser\Node\Stmt\If_ $if) : \PhpParser\Node\Stmt\If_
    {
        /** @var Continue_ $continue */
        $continue = $if->stmts[0];
        $ifs = $this->createMultipleIfs($if->cond, $continue, []);
        $node = $if;
        foreach ($ifs as $key => $if) {
            if ($key === 0) {
                $this->mirrorComments($if, $node);
            }
            $this->addNodeBeforeNode($if, $node);
        }
        $this->removeNode($node);
        return $node;
    }
    /**
     * @param If_[] $ifs
     * @return If_[]
     */
    private function createMultipleIfs(\PhpParser\Node\Expr $expr, \PhpParser\Node\Stmt\Continue_ $continue, array $ifs) : array
    {
        while ($expr instanceof \PhpParser\Node\Expr\BinaryOp\BooleanAnd) {
            $ifs = \array_merge($ifs, $this->collectLeftBooleanAndToIfs($expr, $continue, $ifs));
            $ifs[] = $this->ifManipulator->createIfNegation($expr->right, $continue);
            $expr = $expr->right;
        }
        return $ifs + [$this->ifManipulator->createIfNegation($expr, $continue)];
    }
    /**
     * @param If_[] $ifs
     * @return If_[]
     */
    private function collectLeftBooleanAndToIfs(\PhpParser\Node\Expr\BinaryOp\BooleanAnd $booleanAnd, \PhpParser\Node\Stmt\Continue_ $continue, array $ifs) : array
    {
        $left = $booleanAnd->left;
        if (!$left instanceof \PhpParser\Node\Expr\BinaryOp\BooleanAnd) {
            return [$this->ifManipulator->createIfNegation($left, $continue)];
        }
        return $this->createMultipleIfs($left, $continue, $ifs);
    }
}
