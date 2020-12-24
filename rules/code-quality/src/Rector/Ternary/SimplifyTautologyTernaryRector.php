<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodeQuality\Rector\Ternary;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Ternary;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\BinaryOpManipulator;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\Ternary\SimplifyTautologyTernaryRector\SimplifyTautologyTernaryRectorTest
 */
final class SimplifyTautologyTernaryRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
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
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Simplify tautology ternary to value', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$value = ($fullyQualifiedTypeHint !== $typeHint) ? $fullyQualifiedTypeHint : $typeHint;', '$value = $fullyQualifiedTypeHint;')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\Ternary::class];
    }
    /**
     * @param Ternary $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$node->cond instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotIdentical && !$node->cond instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical) {
            return null;
        }
        $twoNodeMatch = $this->binaryOpManipulator->matchFirstAndSecondConditionNode($node->cond, function (\_PhpScopere8e811afab72\PhpParser\Node $leftNode) use($node) : bool {
            return $this->areNodesEqual($leftNode, $node->if);
        }, function (\_PhpScopere8e811afab72\PhpParser\Node $leftNode) use($node) : bool {
            return $this->areNodesEqual($leftNode, $node->else);
        });
        if ($twoNodeMatch === null) {
            return null;
        }
        return $node->if;
    }
}
