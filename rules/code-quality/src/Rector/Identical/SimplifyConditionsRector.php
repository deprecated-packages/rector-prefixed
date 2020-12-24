<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodeQuality\Rector\Identical;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\BooleanOr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\AssignAndBinaryMap;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\BinaryOpManipulator;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\Identical\SimplifyConditionsRector\SimplifyConditionsRectorTest
 */
final class SimplifyConditionsRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var AssignAndBinaryMap
     */
    private $assignAndBinaryMap;
    /**
     * @var BinaryOpManipulator
     */
    private $binaryOpManipulator;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\AssignAndBinaryMap $assignAndBinaryMap, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\BinaryOpManipulator $binaryOpManipulator)
    {
        $this->assignAndBinaryMap = $assignAndBinaryMap;
        $this->binaryOpManipulator = $binaryOpManipulator;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Simplify conditions', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample("if (! (\$foo !== 'bar')) {...", "if (\$foo === 'bar') {...")]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical::class];
    }
    /**
     * @param BooleanNot|Identical $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot) {
            return $this->processBooleanNot($node);
        }
        return $this->processIdenticalAndNotIdentical($node);
    }
    private function processBooleanNot(\_PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot $booleanNot) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$booleanNot->expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp) {
            return null;
        }
        if ($this->shouldSkip($booleanNot->expr)) {
            return null;
        }
        return $this->createInversedBooleanOp($booleanNot->expr);
    }
    private function processIdenticalAndNotIdentical(\_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical $identical) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $twoNodeMatch = $this->binaryOpManipulator->matchFirstAndSecondConditionNode($identical, function (\_PhpScopere8e811afab72\PhpParser\Node $binaryOp) : bool {
            return $binaryOp instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical || $binaryOp instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotIdentical;
        }, function (\_PhpScopere8e811afab72\PhpParser\Node $binaryOp) : bool {
            return $this->isBool($binaryOp);
        });
        if ($twoNodeMatch === null) {
            return $twoNodeMatch;
        }
        /** @var Identical|NotIdentical $subBinaryOp */
        $subBinaryOp = $twoNodeMatch->getFirstExpr();
        $otherNode = $twoNodeMatch->getSecondExpr();
        if ($this->isFalse($otherNode)) {
            return $this->createInversedBooleanOp($subBinaryOp);
        }
        return $subBinaryOp;
    }
    /**
     * Skip too nested binary || binary > binary combinations
     */
    private function shouldSkip(\_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp $binaryOp) : bool
    {
        if ($binaryOp instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\BooleanOr) {
            return \true;
        }
        if ($binaryOp->left instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp) {
            return \true;
        }
        return $binaryOp->right instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp;
    }
    private function createInversedBooleanOp(\_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp $binaryOp) : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp
    {
        $inversedBinaryClass = $this->assignAndBinaryMap->getInversed($binaryOp);
        if ($inversedBinaryClass === null) {
            return null;
        }
        return new $inversedBinaryClass($binaryOp->left, $binaryOp->right);
    }
}
