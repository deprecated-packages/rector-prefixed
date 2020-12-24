<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PostRector\Collector;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Rector\PostRector\Contract\Collector\NodeCollectorInterface;
final class NodesToAddCollector implements \_PhpScoper0a6b37af0871\Rector\PostRector\Contract\Collector\NodeCollectorInterface
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
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder)
    {
        $this->betterNodeFinder = $betterNodeFinder;
    }
    public function isActive() : bool
    {
        return $this->nodesToAddAfter !== [] || $this->nodesToAddBefore !== [];
    }
    public function addNodeBeforeNode(\_PhpScoper0a6b37af0871\PhpParser\Node $addedNode, \_PhpScoper0a6b37af0871\PhpParser\Node $positionNode) : void
    {
        if ($positionNode->getAttributes() === []) {
            $message = \sprintf('Switch arguments in "%s()" method', __METHOD__);
            throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException($message);
        }
        $position = $this->resolveNearestExpressionPosition($positionNode);
        $this->nodesToAddBefore[$position][] = $this->wrapToExpression($addedNode);
    }
    /**
     * @param Node[] $addedNodes
     */
    public function addNodesAfterNode(array $addedNodes, \_PhpScoper0a6b37af0871\PhpParser\Node $positionNode) : void
    {
        $position = $this->resolveNearestExpressionPosition($positionNode);
        foreach ($addedNodes as $addedNode) {
            // prevent fluent method weird indent
            $addedNode->setAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NODE, null);
            $this->nodesToAddAfter[$position][] = $this->wrapToExpression($addedNode);
        }
    }
    public function addNodeAfterNode(\_PhpScoper0a6b37af0871\PhpParser\Node $addedNode, \_PhpScoper0a6b37af0871\PhpParser\Node $positionNode) : void
    {
        $position = $this->resolveNearestExpressionPosition($positionNode);
        $this->nodesToAddAfter[$position][] = $this->wrapToExpression($addedNode);
    }
    /**
     * @return Stmt[]
     */
    public function getNodesToAddAfterNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : array
    {
        $position = \spl_object_hash($node);
        return $this->nodesToAddAfter[$position] ?? [];
    }
    /**
     * @return Stmt[]
     */
    public function getNodesToAddBeforeNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : array
    {
        $position = \spl_object_hash($node);
        return $this->nodesToAddBefore[$position] ?? [];
    }
    public function clearNodesToAddAfter(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : void
    {
        $objectHash = \spl_object_hash($node);
        unset($this->nodesToAddAfter[$objectHash]);
    }
    public function clearNodesToAddBefore(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : void
    {
        $objectHash = \spl_object_hash($node);
        unset($this->nodesToAddBefore[$objectHash]);
    }
    private function resolveNearestExpressionPosition(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : string
    {
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression || $node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt) {
            return \spl_object_hash($node);
        }
        /** @var Expression|null $foundNode */
        $foundNode = $this->betterNodeFinder->findFirstAncestorInstanceOf($node, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression::class);
        if ($foundNode === null) {
            $foundNode = $node;
        }
        return \spl_object_hash($foundNode);
    }
    /**
     * @param Expr|Stmt $node
     */
    private function wrapToExpression(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt
    {
        return $node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt ? $node : new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression($node);
    }
}
