<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NodeNestingScope;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\FunctionLike;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoper0a2ac50786fa\Rector\NodeNestingScope\ValueObject\ControlStructure;
final class ScopeNestingComparator
{
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder)
    {
        $this->betterNodeFinder = $betterNodeFinder;
    }
    public function areScopeNestingEqual(\_PhpScoper0a2ac50786fa\PhpParser\Node $firstNode, \_PhpScoper0a2ac50786fa\PhpParser\Node $secondNode) : bool
    {
        $firstNodeScopeNode = $this->findParentControlStructure($firstNode);
        $secondNodeScopeNode = $this->findParentControlStructure($secondNode);
        return $firstNodeScopeNode === $secondNodeScopeNode;
    }
    public function isNodeConditionallyScoped(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool
    {
        $foundParentType = $this->betterNodeFinder->findFirstParentInstanceOf($node, \_PhpScoper0a2ac50786fa\Rector\NodeNestingScope\ValueObject\ControlStructure::CONDITIONAL_NODE_SCOPE_TYPES + [\_PhpScoper0a2ac50786fa\PhpParser\Node\FunctionLike::class]);
        if ($foundParentType === null) {
            return \false;
        }
        return !$foundParentType instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\FunctionLike;
    }
    private function findParentControlStructure(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        return $this->betterNodeFinder->findFirstParentInstanceOf($node, \_PhpScoper0a2ac50786fa\Rector\NodeNestingScope\ValueObject\ControlStructure::BREAKING_SCOPE_NODE_TYPES);
    }
}
