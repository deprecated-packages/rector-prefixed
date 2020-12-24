<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\EarlyReturn\Rector\If_;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BooleanNot;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\IfManipulator;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\EarlyReturn\NodeTransformer\ConditionInverter;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\EarlyReturn\Tests\Rector\If_\ChangeNestedIfsToEarlyReturnRector\ChangeNestedIfsToEarlyReturnRectorTest
 */
final class ChangeNestedIfsToEarlyReturnRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var IfManipulator
     */
    private $ifManipulator;
    /**
     * @var ConditionInverter
     */
    private $conditionInverter;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\EarlyReturn\NodeTransformer\ConditionInverter $conditionInverter, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\IfManipulator $ifManipulator)
    {
        $this->ifManipulator = $ifManipulator;
        $this->conditionInverter = $conditionInverter;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change nested ifs to early return', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        if ($value === 5) {
            if ($value2 === 10) {
                return 'yes';
            }
        }

        return 'no';
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        if ($value !== 5) {
            return 'no';
        }

        if ($value2 === 10) {
            return 'yes';
        }

        return 'no';
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_::class];
    }
    /**
     * @param If_ $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        // A. next node is return
        $nextNode = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        if (!$nextNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_) {
            return null;
        }
        $nestedIfsWithOnlyReturn = $this->ifManipulator->collectNestedIfsWithOnlyReturn($node);
        if ($nestedIfsWithOnlyReturn === []) {
            return null;
        }
        $this->processNestedIfsWithOnlyReturn($node, $nestedIfsWithOnlyReturn, $nextNode);
        $this->removeNode($node);
        return null;
    }
    /**
     * @param If_[] $nestedIfsWithOnlyReturn
     */
    private function processNestedIfsWithOnlyReturn(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_ $if, array $nestedIfsWithOnlyReturn, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_ $nextReturn) : void
    {
        // add nested if openly after this
        $nestedIfsWithOnlyReturnCount = \count($nestedIfsWithOnlyReturn);
        /** @var int $key */
        foreach ($nestedIfsWithOnlyReturn as $key => $nestedIfWithOnlyReturn) {
            // last item → the return node
            if ($nestedIfsWithOnlyReturnCount === $key + 1) {
                $this->addNodeAfterNode($nestedIfWithOnlyReturn, $if);
            } else {
                $this->addStandaloneIfsWithReturn($nestedIfWithOnlyReturn, $if, $nextReturn);
            }
        }
    }
    private function addStandaloneIfsWithReturn(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_ $nestedIfWithOnlyReturn, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_ $if, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_ $return) : void
    {
        $return = clone $return;
        $invertedCondition = $this->conditionInverter->createInvertedCondition($nestedIfWithOnlyReturn->cond);
        // special case
        if ($invertedCondition instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BooleanNot && $invertedCondition->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\BooleanAnd) {
            $booleanNotPartIf = new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BooleanNot($invertedCondition->expr->left));
            $booleanNotPartIf->stmts = [clone $return];
            $this->addNodeAfterNode($booleanNotPartIf, $if);
            $booleanNotPartIf = new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BooleanNot($invertedCondition->expr->right));
            $booleanNotPartIf->stmts = [clone $return];
            $this->addNodeAfterNode($booleanNotPartIf, $if);
            return;
        }
        $nestedIfWithOnlyReturn->cond = $invertedCondition;
        $nestedIfWithOnlyReturn->stmts = [clone $return];
        $this->addNodeAfterNode($nestedIfWithOnlyReturn, $if);
    }
}
