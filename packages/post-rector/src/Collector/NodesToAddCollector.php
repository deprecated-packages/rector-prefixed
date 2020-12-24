<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PostRector\Collector;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\PostRector\Contract\Collector\NodeCollectorInterface;
final class NodesToAddCollector implements \_PhpScoperb75b35f52b74\Rector\PostRector\Contract\Collector\NodeCollectorInterface
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder)
    {
        $this->betterNodeFinder = $betterNodeFinder;
    }
    public function isActive() : bool
    {
        return $this->nodesToAddAfter !== [] || $this->nodesToAddBefore !== [];
    }
    public function addNodeBeforeNode(\_PhpScoperb75b35f52b74\PhpParser\Node $addedNode, \_PhpScoperb75b35f52b74\PhpParser\Node $positionNode) : void
    {
        if ($positionNode->getAttributes() === []) {
            $message = \sprintf('Switch arguments in "%s()" method', __METHOD__);
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException($message);
        }
        $position = $this->resolveNearestExpressionPosition($positionNode);
        $this->nodesToAddBefore[$position][] = $this->wrapToExpression($addedNode);
    }
    /**
     * @param Node[] $addedNodes
     */
    public function addNodesAfterNode(array $addedNodes, \_PhpScoperb75b35f52b74\PhpParser\Node $positionNode) : void
    {
        $position = $this->resolveNearestExpressionPosition($positionNode);
        foreach ($addedNodes as $addedNode) {
            // prevent fluent method weird indent
            $addedNode->setAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NODE, null);
            $this->nodesToAddAfter[$position][] = $this->wrapToExpression($addedNode);
        }
    }
    public function addNodeAfterNode(\_PhpScoperb75b35f52b74\PhpParser\Node $addedNode, \_PhpScoperb75b35f52b74\PhpParser\Node $positionNode) : void
    {
        $position = $this->resolveNearestExpressionPosition($positionNode);
        $this->nodesToAddAfter[$position][] = $this->wrapToExpression($addedNode);
    }
    /**
     * @return Stmt[]
     */
    public function getNodesToAddAfterNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : array
    {
        $position = \spl_object_hash($node);
        return $this->nodesToAddAfter[$position] ?? [];
    }
    /**
     * @return Stmt[]
     */
    public function getNodesToAddBeforeNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : array
    {
        $position = \spl_object_hash($node);
        return $this->nodesToAddBefore[$position] ?? [];
    }
    public function clearNodesToAddAfter(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : void
    {
        $objectHash = \spl_object_hash($node);
        unset($this->nodesToAddAfter[$objectHash]);
    }
    public function clearNodesToAddBefore(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : void
    {
        $objectHash = \spl_object_hash($node);
        unset($this->nodesToAddBefore[$objectHash]);
    }
    private function resolveNearestExpressionPosition(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : string
    {
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression || $node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt) {
            return \spl_object_hash($node);
        }
        /** @var Expression|null $foundNode */
        $foundNode = $this->betterNodeFinder->findFirstAncestorInstanceOf($node, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression::class);
        if ($foundNode === null) {
            $foundNode = $node;
        }
        return \spl_object_hash($foundNode);
    }
    /**
     * @param Expr|Stmt $node
     */
    private function wrapToExpression(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt
    {
        return $node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt ? $node : new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression($node);
    }
}
