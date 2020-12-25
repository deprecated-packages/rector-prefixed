<?php

declare (strict_types=1);
namespace Rector\NodeNestingScope;

use PhpParser\Node;
use PhpParser\Node\FunctionLike;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use Rector\NodeNestingScope\ValueObject\ControlStructure;
final class ScopeNestingComparator
{
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    public function __construct(\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder)
    {
        $this->betterNodeFinder = $betterNodeFinder;
    }
    public function areScopeNestingEqual(\PhpParser\Node $firstNode, \PhpParser\Node $secondNode) : bool
    {
        $firstNodeScopeNode = $this->findParentControlStructure($firstNode);
        $secondNodeScopeNode = $this->findParentControlStructure($secondNode);
        return $firstNodeScopeNode === $secondNodeScopeNode;
    }
    public function isNodeConditionallyScoped(\PhpParser\Node $node) : bool
    {
        $foundParentType = $this->betterNodeFinder->findFirstParentInstanceOf($node, \Rector\NodeNestingScope\ValueObject\ControlStructure::CONDITIONAL_NODE_SCOPE_TYPES + [\PhpParser\Node\FunctionLike::class]);
        if ($foundParentType === null) {
            return \false;
        }
        return !$foundParentType instanceof \PhpParser\Node\FunctionLike;
    }
    private function findParentControlStructure(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        return $this->betterNodeFinder->findFirstParentInstanceOf($node, \Rector\NodeNestingScope\ValueObject\ControlStructure::BREAKING_SCOPE_NODE_TYPES);
    }
}
