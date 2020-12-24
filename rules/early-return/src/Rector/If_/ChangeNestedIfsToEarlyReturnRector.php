<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\EarlyReturn\Rector\If_;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BooleanNot;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\If_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\IfManipulator;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\EarlyReturn\NodeTransformer\ConditionInverter;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\EarlyReturn\Tests\Rector\If_\ChangeNestedIfsToEarlyReturnRector\ChangeNestedIfsToEarlyReturnRectorTest
 */
final class ChangeNestedIfsToEarlyReturnRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var IfManipulator
     */
    private $ifManipulator;
    /**
     * @var ConditionInverter
     */
    private $conditionInverter;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\EarlyReturn\NodeTransformer\ConditionInverter $conditionInverter, \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\IfManipulator $ifManipulator)
    {
        $this->ifManipulator = $ifManipulator;
        $this->conditionInverter = $conditionInverter;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change nested ifs to early return', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\If_::class];
    }
    /**
     * @param If_ $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        // A. next node is return
        $nextNode = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        if (!$nextNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_) {
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
    private function processNestedIfsWithOnlyReturn(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\If_ $if, array $nestedIfsWithOnlyReturn, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_ $nextReturn) : void
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
    private function addStandaloneIfsWithReturn(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\If_ $nestedIfWithOnlyReturn, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\If_ $if, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_ $return) : void
    {
        $return = clone $return;
        $invertedCondition = $this->conditionInverter->createInvertedCondition($nestedIfWithOnlyReturn->cond);
        // special case
        if ($invertedCondition instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BooleanNot && $invertedCondition->expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\BooleanAnd) {
            $booleanNotPartIf = new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\If_(new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BooleanNot($invertedCondition->expr->left));
            $booleanNotPartIf->stmts = [clone $return];
            $this->addNodeAfterNode($booleanNotPartIf, $if);
            $booleanNotPartIf = new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\If_(new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BooleanNot($invertedCondition->expr->right));
            $booleanNotPartIf->stmts = [clone $return];
            $this->addNodeAfterNode($booleanNotPartIf, $if);
            return;
        }
        $nestedIfWithOnlyReturn->cond = $invertedCondition;
        $nestedIfWithOnlyReturn->stmts = [clone $return];
        $this->addNodeAfterNode($nestedIfWithOnlyReturn, $if);
    }
}
