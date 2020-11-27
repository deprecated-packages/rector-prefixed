<?php

declare (strict_types=1);
namespace Rector\CodeQuality\Rector\Ternary;

use PhpParser\Node;
use PhpParser\Node\Expr\BinaryOp\Identical;
use PhpParser\Node\Expr\BinaryOp\NotIdentical;
use PhpParser\Node\Expr\Ternary;
use Rector\Core\PhpParser\Node\Manipulator\BinaryOpManipulator;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\Ternary\SimplifyTautologyTernaryRector\SimplifyTautologyTernaryRectorTest
 */
final class SimplifyTautologyTernaryRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var BinaryOpManipulator
     */
    private $binaryOpManipulator;
    public function __construct(\Rector\Core\PhpParser\Node\Manipulator\BinaryOpManipulator $binaryOpManipulator)
    {
        $this->binaryOpManipulator = $binaryOpManipulator;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Simplify tautology ternary to value', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$value = ($fullyQualifiedTypeHint !== $typeHint) ? $fullyQualifiedTypeHint : $typeHint;', '$value = $fullyQualifiedTypeHint;')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\Ternary::class];
    }
    /**
     * @param Ternary $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$node->cond instanceof \PhpParser\Node\Expr\BinaryOp\NotIdentical && !$node->cond instanceof \PhpParser\Node\Expr\BinaryOp\Identical) {
            return null;
        }
        $twoNodeMatch = $this->binaryOpManipulator->matchFirstAndSecondConditionNode($node->cond, function (\PhpParser\Node $leftNode) use($node) : bool {
            return $this->areNodesEqual($leftNode, $node->if);
        }, function (\PhpParser\Node $leftNode) use($node) : bool {
            return $this->areNodesEqual($leftNode, $node->else);
        });
        if ($twoNodeMatch === null) {
            return null;
        }
        return $node->if;
    }
}
