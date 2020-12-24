<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PostRector\Collector;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\PostRector\Contract\Collector\NodeCollectorInterface;
final class NodesToAddCollector implements \_PhpScopere8e811afab72\Rector\PostRector\Contract\Collector\NodeCollectorInterface
{
    /**
     * @var Stmt[][]
     */
    private $nodesToAddAfter = [];
    /**
     * @var Stmt[][]
     */
    private $nodesToAddBefore = [];
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder)
    {
        $this->betterNodeFinder = $betterNodeFinder;
    }
    public function isActive() : bool
    {
        return $this->nodesToAddAfter !== [] || $this->nodesToAddBefore !== [];
    }
    public function addNodeBeforeNode(\_PhpScopere8e811afab72\PhpParser\Node $addedNode, \_PhpScopere8e811afab72\PhpParser\Node $positionNode) : void
    {
        if ($positionNode->getAttributes() === []) {
            $message = \sprintf('Switch arguments in "%s()" method', __METHOD__);
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException($message);
        }
        $position = $this->resolveNearestExpressionPosition($positionNode);
        $this->nodesToAddBefore[$position][] = $this->wrapToExpression($addedNode);
    }
    /**
     * @param Node[] $addedNodes
     */
    public function addNodesAfterNode(array $addedNodes, \_PhpScopere8e811afab72\PhpParser\Node $positionNode) : void
    {
        $position = $this->resolveNearestExpressionPosition($positionNode);
        foreach ($addedNodes as $addedNode) {
            // prevent fluent method weird indent
            $addedNode->setAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NODE, null);
            $this->nodesToAddAfter[$position][] = $this->wrapToExpression($addedNode);
        }
    }
    public function addNodeAfterNode(\_PhpScopere8e811afab72\PhpParser\Node $addedNode, \_PhpScopere8e811afab72\PhpParser\Node $positionNode) : void
    {
        $position = $this->resolveNearestExpressionPosition($positionNode);
        $this->nodesToAddAfter[$position][] = $this->wrapToExpression($addedNode);
    }
    /**
     * @return Stmt[]
     */
    public function getNodesToAddAfterNode(\_PhpScopere8e811afab72\PhpParser\Node $node) : array
    {
        $position = \spl_object_hash($node);
        return $this->nodesToAddAfter[$position] ?? [];
    }
    /**
     * @return Stmt[]
     */
    public function getNodesToAddBeforeNode(\_PhpScopere8e811afab72\PhpParser\Node $node) : array
    {
        $position = \spl_object_hash($node);
        return $this->nodesToAddBefore[$position] ?? [];
    }
    public function clearNodesToAddAfter(\_PhpScopere8e811afab72\PhpParser\Node $node) : void
    {
        $objectHash = \spl_object_hash($node);
        unset($this->nodesToAddAfter[$objectHash]);
    }
    public function clearNodesToAddBefore(\_PhpScopere8e811afab72\PhpParser\Node $node) : void
    {
        $objectHash = \spl_object_hash($node);
        unset($this->nodesToAddBefore[$objectHash]);
    }
    private function resolveNearestExpressionPosition(\_PhpScopere8e811afab72\PhpParser\Node $node) : string
    {
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression || $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt) {
            return \spl_object_hash($node);
        }
        /** @var Expression|null $foundNode */
        $foundNode = $this->betterNodeFinder->findFirstAncestorInstanceOf($node, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression::class);
        if ($foundNode === null) {
            $foundNode = $node;
        }
        return \spl_object_hash($foundNode);
    }
    /**
     * @param Expr|Stmt $node
     */
    private function wrapToExpression(\_PhpScopere8e811afab72\PhpParser\Node $node) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt
    {
        return $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt ? $node : new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression($node);
    }
}
