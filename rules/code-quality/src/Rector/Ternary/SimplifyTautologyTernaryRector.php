<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CodeQuality\Rector\Ternary;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Ternary;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\BinaryOpManipulator;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\Ternary\SimplifyTautologyTernaryRector\SimplifyTautologyTernaryRectorTest
 */
final class SimplifyTautologyTernaryRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var BinaryOpManipulator
     */
    private $binaryOpManipulator;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\BinaryOpManipulator $binaryOpManipulator)
    {
        $this->binaryOpManipulator = $binaryOpManipulator;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Simplify tautology ternary to value', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$value = ($fullyQualifiedTypeHint !== $typeHint) ? $fullyQualifiedTypeHint : $typeHint;', '$value = $fullyQualifiedTypeHint;')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Ternary::class];
    }
    /**
     * @param Ternary $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if (!$node->cond instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\NotIdentical && !$node->cond instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical) {
            return null;
        }
        $twoNodeMatch = $this->binaryOpManipulator->matchFirstAndSecondConditionNode($node->cond, function (\_PhpScoper0a6b37af0871\PhpParser\Node $leftNode) use($node) : bool {
            return $this->areNodesEqual($leftNode, $node->if);
        }, function (\_PhpScoper0a6b37af0871\PhpParser\Node $leftNode) use($node) : bool {
            return $this->areNodesEqual($leftNode, $node->else);
        });
        if ($twoNodeMatch === null) {
            return null;
        }
        return $node->if;
    }
}
