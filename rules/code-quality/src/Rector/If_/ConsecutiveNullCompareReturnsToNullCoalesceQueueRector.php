<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\If_;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Coalesce;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\If_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Return_;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\Manipulator\IfManipulator;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\If_\ConsecutiveNullCompareReturnsToNullCoalesceQueueRector\ConsecutiveNullCompareReturnsToNullCoalesceQueueRectorTest
 */
final class ConsecutiveNullCompareReturnsToNullCoalesceQueueRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
{
    /**
     * @var Node[]
     */
    private $nodesToRemove = [];
    /**
     * @var Expr[]
     */
    private $coalescingNodes = [];
    /**
     * @var IfManipulator
     */
    private $ifManipulator;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\Manipulator\IfManipulator $ifManipulator)
    {
        $this->ifManipulator = $ifManipulator;
    }
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change multiple null compares to ?? queue', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        if (null !== $this->orderItem) {
            return $this->orderItem;
        }

        if (null !== $this->orderItemUnit) {
            return $this->orderItemUnit;
        }

        return null;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        return $this->orderItem ?? $this->orderItemUnit;
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
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\If_::class];
    }
    /**
     * @param If_ $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        if (!$this->isAtLeastPhpVersion(\_PhpScoper2a4e7ab1ecbc\Rector\Core\ValueObject\PhpVersionFeature::NULL_COALESCE)) {
            return null;
        }
        $this->reset();
        $currentNode = $node;
        while ($currentNode !== null) {
            if ($currentNode instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\If_) {
                $comparedNode = $this->ifManipulator->matchIfNotNullReturnValue($currentNode);
                if ($comparedNode !== null) {
                    $this->coalescingNodes[] = $comparedNode;
                    $this->nodesToRemove[] = $currentNode;
                    $currentNode = $currentNode->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
                    continue;
                }
                return null;
            }
            if ($this->isReturnNull($currentNode)) {
                $this->nodesToRemove[] = $currentNode;
                break;
            }
            return null;
        }
        // at least 2 coalescing nodes are needed
        if (\count($this->coalescingNodes) < 2) {
            return null;
        }
        $this->removeNodes($this->nodesToRemove);
        return $this->createReturnCoalesceNode($this->coalescingNodes);
    }
    private function reset() : void
    {
        $this->coalescingNodes = [];
        $this->nodesToRemove = [];
    }
    private function isReturnNull(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : bool
    {
        if (!$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Return_) {
            return \false;
        }
        if ($node->expr === null) {
            return \false;
        }
        return $this->isNull($node->expr);
    }
    /**
     * @param Expr[] $coalescingNodes
     */
    private function createReturnCoalesceNode(array $coalescingNodes) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Return_
    {
        /** @var Expr $left */
        $left = \array_shift($coalescingNodes);
        /** @var Expr $right */
        $right = \array_shift($coalescingNodes);
        $coalesceNode = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Coalesce($left, $right);
        foreach ($coalescingNodes as $nextCoalescingNode) {
            $coalesceNode = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Coalesce($coalesceNode, $nextCoalescingNode);
        }
        return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Return_($coalesceNode);
    }
}
