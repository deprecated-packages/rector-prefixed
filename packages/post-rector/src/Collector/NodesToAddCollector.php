<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\PostRector\Collector;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Rector\PostRector\Contract\Collector\NodeCollectorInterface;
final class NodesToAddCollector implements \_PhpScoper2a4e7ab1ecbc\Rector\PostRector\Contract\Collector\NodeCollectorInterface
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder)
    {
        $this->betterNodeFinder = $betterNodeFinder;
    }
    public function isActive() : bool
    {
        return $this->nodesToAddAfter !== [] || $this->nodesToAddBefore !== [];
    }
    public function addNodeBeforeNode(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $addedNode, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node $positionNode) : void
    {
        if ($positionNode->getAttributes() === []) {
            $message = \sprintf('Switch arguments in "%s()" method', __METHOD__);
            throw new \_PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException($message);
        }
        $position = $this->resolveNearestExpressionPosition($positionNode);
        $this->nodesToAddBefore[$position][] = $this->wrapToExpression($addedNode);
    }
    /**
     * @param Node[] $addedNodes
     */
    public function addNodesAfterNode(array $addedNodes, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node $positionNode) : void
    {
        $position = $this->resolveNearestExpressionPosition($positionNode);
        foreach ($addedNodes as $addedNode) {
            // prevent fluent method weird indent
            $addedNode->setAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NODE, null);
            $this->nodesToAddAfter[$position][] = $this->wrapToExpression($addedNode);
        }
    }
    public function addNodeAfterNode(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $addedNode, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node $positionNode) : void
    {
        $position = $this->resolveNearestExpressionPosition($positionNode);
        $this->nodesToAddAfter[$position][] = $this->wrapToExpression($addedNode);
    }
    /**
     * @return Stmt[]
     */
    public function getNodesToAddAfterNode(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : array
    {
        $position = \spl_object_hash($node);
        return $this->nodesToAddAfter[$position] ?? [];
    }
    /**
     * @return Stmt[]
     */
    public function getNodesToAddBeforeNode(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : array
    {
        $position = \spl_object_hash($node);
        return $this->nodesToAddBefore[$position] ?? [];
    }
    public function clearNodesToAddAfter(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : void
    {
        $objectHash = \spl_object_hash($node);
        unset($this->nodesToAddAfter[$objectHash]);
    }
    public function clearNodesToAddBefore(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : void
    {
        $objectHash = \spl_object_hash($node);
        unset($this->nodesToAddBefore[$objectHash]);
    }
    private function resolveNearestExpressionPosition(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : string
    {
        if ($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression) {
            return \spl_object_hash($node);
        }
        if ($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt) {
            return \spl_object_hash($node);
        }
        /** @var Expression|null $foundNode */
        $foundNode = $this->betterNodeFinder->findFirstAncestorInstanceOf($node, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression::class);
        if ($foundNode === null) {
            $foundNode = $node;
        }
        return \spl_object_hash($foundNode);
    }
    /**
     * @param Expr|Stmt $node
     */
    private function wrapToExpression(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt
    {
        return $node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt ? $node : new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression($node);
    }
}
