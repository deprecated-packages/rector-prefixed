<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodeQuality\Rector\Ternary;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Ternary;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\BinaryOpManipulator;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\Ternary\SimplifyTautologyTernaryRector\SimplifyTautologyTernaryRectorTest
 */
final class SimplifyTautologyTernaryRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var BinaryOpManipulator
     */
    private $binaryOpManipulator;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\BinaryOpManipulator $binaryOpManipulator)
    {
        $this->binaryOpManipulator = $binaryOpManipulator;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Simplify tautology ternary to value', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$value = ($fullyQualifiedTypeHint !== $typeHint) ? $fullyQualifiedTypeHint : $typeHint;', '$value = $fullyQualifiedTypeHint;')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Ternary::class];
    }
    /**
     * @param Ternary $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$node->cond instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\NotIdentical && !$node->cond instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical) {
            return null;
        }
        $twoNodeMatch = $this->binaryOpManipulator->matchFirstAndSecondConditionNode($node->cond, function (\_PhpScoperb75b35f52b74\PhpParser\Node $leftNode) use($node) : bool {
            return $this->areNodesEqual($leftNode, $node->if);
        }, function (\_PhpScoperb75b35f52b74\PhpParser\Node $leftNode) use($node) : bool {
            return $this->areNodesEqual($leftNode, $node->else);
        });
        if ($twoNodeMatch === null) {
            return null;
        }
        return $node->if;
    }
}
