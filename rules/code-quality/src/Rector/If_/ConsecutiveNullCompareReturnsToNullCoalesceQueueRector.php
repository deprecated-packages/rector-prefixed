<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodeQuality\Rector\If_;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Coalesce;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\IfManipulator;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\If_\ConsecutiveNullCompareReturnsToNullCoalesceQueueRector\ConsecutiveNullCompareReturnsToNullCoalesceQueueRectorTest
 */
final class ConsecutiveNullCompareReturnsToNullCoalesceQueueRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\IfManipulator $ifManipulator)
    {
        $this->ifManipulator = $ifManipulator;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change multiple null compares to ?? queue', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_::class];
    }
    /**
     * @param If_ $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$this->isAtLeastPhpVersion(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\PhpVersionFeature::NULL_COALESCE)) {
            return null;
        }
        $this->reset();
        $currentNode = $node;
        while ($currentNode !== null) {
            if ($currentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_) {
                $comparedNode = $this->ifManipulator->matchIfNotNullReturnValue($currentNode);
                if ($comparedNode !== null) {
                    $this->coalescingNodes[] = $comparedNode;
                    $this->nodesToRemove[] = $currentNode;
                    $currentNode = $currentNode->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
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
    private function isReturnNull(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
    {
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_) {
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
    private function createReturnCoalesceNode(array $coalescingNodes) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_
    {
        /** @var Expr $left */
        $left = \array_shift($coalescingNodes);
        /** @var Expr $right */
        $right = \array_shift($coalescingNodes);
        $coalesceNode = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Coalesce($left, $right);
        foreach ($coalescingNodes as $nextCoalescingNode) {
            $coalesceNode = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Coalesce($coalesceNode, $nextCoalescingNode);
        }
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_($coalesceNode);
    }
}
