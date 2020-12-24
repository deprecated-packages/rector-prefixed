<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeNestingScope;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\FunctionLike;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScopere8e811afab72\Rector\NodeNestingScope\ValueObject\ControlStructure;
final class ScopeNestingComparator
{
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder)
    {
        $this->betterNodeFinder = $betterNodeFinder;
    }
    public function areScopeNestingEqual(\_PhpScopere8e811afab72\PhpParser\Node $firstNode, \_PhpScopere8e811afab72\PhpParser\Node $secondNode) : bool
    {
        $firstNodeScopeNode = $this->findParentControlStructure($firstNode);
        $secondNodeScopeNode = $this->findParentControlStructure($secondNode);
        return $firstNodeScopeNode === $secondNodeScopeNode;
    }
    public function isNodeConditionallyScoped(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        $foundParentType = $this->betterNodeFinder->findFirstParentInstanceOf($node, \_PhpScopere8e811afab72\Rector\NodeNestingScope\ValueObject\ControlStructure::CONDITIONAL_NODE_SCOPE_TYPES + [\_PhpScopere8e811afab72\PhpParser\Node\FunctionLike::class]);
        if ($foundParentType === null) {
            return \false;
        }
        return !$foundParentType instanceof \_PhpScopere8e811afab72\PhpParser\Node\FunctionLike;
    }
    private function findParentControlStructure(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        return $this->betterNodeFinder->findFirstParentInstanceOf($node, \_PhpScopere8e811afab72\Rector\NodeNestingScope\ValueObject\ControlStructure::BREAKING_SCOPE_NODE_TYPES);
    }
}
