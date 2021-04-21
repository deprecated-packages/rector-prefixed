<?php

declare(strict_types=1);

namespace Rector\PostRector\Collector;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Return_;
use Rector\ChangesReporting\Collector\RectorChangeCollector;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\PostRector\Contract\Collector\NodeCollectorInterface;

final class NodesToAddCollector implements NodeCollectorInterface
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

    /**
     * @var RectorChangeCollector
     */
    private $rectorChangeCollector;

    public function __construct(BetterNodeFinder $betterNodeFinder, RectorChangeCollector $rectorChangeCollector)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->rectorChangeCollector = $rectorChangeCollector;
    }

    public function isActive(): bool
    {
        return $this->nodesToAddAfter !== [] || $this->nodesToAddBefore !== [];
    }

    /**
     * @return void
     */
    public function addNodeBeforeNode(Node $addedNode, Node $positionNode)
    {
        if ($positionNode->getAttributes() === []) {
            $message = sprintf('Switch arguments in "%s()" method', __METHOD__);
            throw new ShouldNotHappenException($message);
        }

        $position = $this->resolveNearestExpressionPosition($positionNode);
        $this->nodesToAddBefore[$position][] = $this->wrapToExpression($addedNode);

        $this->rectorChangeCollector->notifyNodeFileInfo($positionNode);
    }

    /**
     * @param Node[] $addedNodes
     * @return void
     */
    public function addNodesAfterNode(array $addedNodes, Node $positionNode)
    {
        $position = $this->resolveNearestExpressionPosition($positionNode);
        foreach ($addedNodes as $addedNode) {
            // prevent fluent method weird indent
            $addedNode->setAttribute(AttributeKey::ORIGINAL_NODE, null);
            $this->nodesToAddAfter[$position][] = $this->wrapToExpression($addedNode);
        }

        $this->rectorChangeCollector->notifyNodeFileInfo($positionNode);
    }

    /**
     * @return void
     */
    public function addNodeAfterNode(Node $addedNode, Node $positionNode)
    {
        $position = $this->resolveNearestExpressionPosition($positionNode);
        $this->nodesToAddAfter[$position][] = $this->wrapToExpression($addedNode);

        $this->rectorChangeCollector->notifyNodeFileInfo($positionNode);
    }

    /**
     * @return Stmt[]
     */
    public function getNodesToAddAfterNode(Node $node): array
    {
        $position = spl_object_hash($node);
        return $this->nodesToAddAfter[$position] ?? [];
    }

    /**
     * @return Stmt[]
     */
    public function getNodesToAddBeforeNode(Node $node): array
    {
        $position = spl_object_hash($node);
        return $this->nodesToAddBefore[$position] ?? [];
    }

    /**
     * @return void
     */
    public function clearNodesToAddAfter(Node $node)
    {
        $objectHash = spl_object_hash($node);
        unset($this->nodesToAddAfter[$objectHash]);
    }

    /**
     * @return void
     */
    public function clearNodesToAddBefore(Node $node)
    {
        $objectHash = spl_object_hash($node);
        unset($this->nodesToAddBefore[$objectHash]);
    }

    /**
     * @param Node[] $newNodes
     * @return void
     */
    public function addNodesBeforeNode(array $newNodes, Node $positionNode)
    {
        foreach ($newNodes as $newNode) {
            $this->addNodeBeforeNode($newNode, $positionNode);
        }

        $this->rectorChangeCollector->notifyNodeFileInfo($positionNode);
    }

    private function resolveNearestExpressionPosition(Node $node): string
    {
        if ($node instanceof Expression || $node instanceof Stmt) {
            return spl_object_hash($node);
        }

        $parent = $node->getAttribute(AttributeKey::PARENT_NODE);
        if ($parent instanceof Return_) {
            return spl_object_hash($parent);
        }

        $foundNode = $this->betterNodeFinder->findParentType($node, Expression::class);
        if (! $foundNode instanceof Expression) {
            $foundNode = $node;
        }

        return spl_object_hash($foundNode);
    }

    /**
     * @param Expr|Stmt $node
     */
    private function wrapToExpression(Node $node): Stmt
    {
        return $node instanceof Stmt ? $node : new Expression($node);
    }
}
