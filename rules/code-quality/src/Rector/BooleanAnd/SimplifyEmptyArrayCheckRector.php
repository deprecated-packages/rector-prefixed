<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodeQuality\Rector\BooleanAnd;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Array_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Empty_;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\BinaryOpManipulator;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://3v4l.org/EZ2P4
 * @see https://3v4l.org/egtb5
 * @see \Rector\CodeQuality\Tests\Rector\BooleanAnd\SimplifyEmptyArrayCheckRector\SimplifyEmptyArrayCheckRectorTest
 */
final class SimplifyEmptyArrayCheckRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var BinaryOpManipulator
     */
    private $binaryOpManipulator;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\BinaryOpManipulator $binaryOpManipulator)
    {
        $this->binaryOpManipulator = $binaryOpManipulator;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Simplify `is_array` and `empty` functions combination into a simple identical check for an empty array', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('is_array($values) && empty($values)', '$values === []')]);
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
        $twoNodeMatch = $this->binaryOpManipulator->matchFirstAndSecondConditionNode(
            $node,
            // is_array(...)
            function (\_PhpScopere8e811afab72\PhpParser\Node $node) : bool {
                return $this->isFuncCallName($node, 'is_array');
            },
            \_PhpScopere8e811afab72\PhpParser\Node\Expr\Empty_::class
        );
        if ($twoNodeMatch === null) {
            return null;
        }
        /** @var Empty_ $emptyOrNotIdenticalNode */
        $emptyOrNotIdenticalNode = $twoNodeMatch->getSecondExpr();
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical($emptyOrNotIdenticalNode->expr, new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_());
    }
}
