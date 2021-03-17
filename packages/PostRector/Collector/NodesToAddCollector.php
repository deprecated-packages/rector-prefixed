<?php

declare (strict_types=1);
namespace Rector\PostRector\Collector;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\Expression;
use Rector\ChangesReporting\Collector\RectorChangeCollector;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use Rector\Core\Util\StaticInstanceOf;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\PostRector\Contract\Collector\NodeCollectorInterface;
final class NodesToAddCollector implements \Rector\PostRector\Contract\Collector\NodeCollectorInterface
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
    public function __construct(\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \Rector\ChangesReporting\Collector\RectorChangeCollector $rectorChangeCollector)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->rectorChangeCollector = $rectorChangeCollector;
    }
    public function isActive() : bool
    {
        return $this->nodesToAddAfter !== [] || $this->nodesToAddBefore !== [];
    }
    /**
     * @param \PhpParser\Node $addedNode
     * @param \PhpParser\Node $positionNode
     */
    public function addNodeBeforeNode($addedNode, $positionNode) : void
    {
        if ($positionNode->getAttributes() === []) {
            $message = \sprintf('Switch arguments in "%s()" method', __METHOD__);
            throw new \Rector\Core\Exception\ShouldNotHappenException($message);
        }
        $position = $this->resolveNearestExpressionPosition($positionNode);
        $this->nodesToAddBefore[$position][] = $this->wrapToExpression($addedNode);
        $this->rectorChangeCollector->notifyNodeFileInfo($positionNode);
    }
    /**
     * @param Node[] $addedNodes
     * @param \PhpParser\Node $positionNode
     */
    public function addNodesAfterNode($addedNodes, $positionNode) : void
    {
        $position = $this->resolveNearestExpressionPosition($positionNode);
        foreach ($addedNodes as $addedNode) {
            // prevent fluent method weird indent
            $addedNode->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NODE, null);
            $this->nodesToAddAfter[$position][] = $this->wrapToExpression($addedNode);
        }
        $this->rectorChangeCollector->notifyNodeFileInfo($positionNode);
    }
    /**
     * @param \PhpParser\Node $addedNode
     * @param \PhpParser\Node $positionNode
     */
    public function addNodeAfterNode($addedNode, $positionNode) : void
    {
        $position = $this->resolveNearestExpressionPosition($positionNode);
        $this->nodesToAddAfter[$position][] = $this->wrapToExpression($addedNode);
        $this->rectorChangeCollector->notifyNodeFileInfo($positionNode);
    }
    /**
     * @return Stmt[]
     * @param \PhpParser\Node $node
     */
    public function getNodesToAddAfterNode($node) : array
    {
        $position = \spl_object_hash($node);
        return $this->nodesToAddAfter[$position] ?? [];
    }
    /**
     * @return Stmt[]
     * @param \PhpParser\Node $node
     */
    public function getNodesToAddBeforeNode($node) : array
    {
        $position = \spl_object_hash($node);
        return $this->nodesToAddBefore[$position] ?? [];
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function clearNodesToAddAfter($node) : void
    {
        $objectHash = \spl_object_hash($node);
        unset($this->nodesToAddAfter[$objectHash]);
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function clearNodesToAddBefore($node) : void
    {
        $objectHash = \spl_object_hash($node);
        unset($this->nodesToAddBefore[$objectHash]);
    }
    /**
     * @param Node[] $newNodes
     * @param \PhpParser\Node $positionNode
     */
    public function addNodesBeforeNode($newNodes, $positionNode) : void
    {
        foreach ($newNodes as $newNode) {
            $this->addNodeBeforeNode($newNode, $positionNode);
        }
        $this->rectorChangeCollector->notifyNodeFileInfo($positionNode);
    }
    /**
     * @param \PhpParser\Node $node
     */
    private function resolveNearestExpressionPosition($node) : string
    {
        if (\Rector\Core\Util\StaticInstanceOf::isOneOf($node, [\PhpParser\Node\Stmt\Expression::class, \PhpParser\Node\Stmt::class])) {
            return \spl_object_hash($node);
        }
        $foundNode = $this->betterNodeFinder->findFirstAncestorInstanceOf($node, \PhpParser\Node\Stmt\Expression::class);
        if (!$foundNode instanceof \PhpParser\Node\Stmt\Expression) {
            $foundNode = $node;
        }
        return \spl_object_hash($foundNode);
    }
    /**
     * @param Expr|Stmt $node
     */
    private function wrapToExpression($node) : \PhpParser\Node\Stmt
    {
        return $node instanceof \PhpParser\Node\Stmt ? $node : new \PhpParser\Node\Stmt\Expression($node);
    }
}
