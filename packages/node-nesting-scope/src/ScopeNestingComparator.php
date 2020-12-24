<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NodeNestingScope;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoperb75b35f52b74\Rector\NodeNestingScope\ValueObject\ControlStructure;
final class ScopeNestingComparator
{
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder)
    {
        $this->betterNodeFinder = $betterNodeFinder;
    }
    public function areScopeNestingEqual(\_PhpScoperb75b35f52b74\PhpParser\Node $firstNode, \_PhpScoperb75b35f52b74\PhpParser\Node $secondNode) : bool
    {
        $firstNodeScopeNode = $this->findParentControlStructure($firstNode);
        $secondNodeScopeNode = $this->findParentControlStructure($secondNode);
        return $firstNodeScopeNode === $secondNodeScopeNode;
    }
    public function isNodeConditionallyScoped(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
    {
        $foundParentType = $this->betterNodeFinder->findFirstParentInstanceOf($node, \_PhpScoperb75b35f52b74\Rector\NodeNestingScope\ValueObject\ControlStructure::CONDITIONAL_NODE_SCOPE_TYPES + [\_PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike::class]);
        if ($foundParentType === null) {
            return \false;
        }
        return !$foundParentType instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike;
    }
    private function findParentControlStructure(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        return $this->betterNodeFinder->findFirstParentInstanceOf($node, \_PhpScoperb75b35f52b74\Rector\NodeNestingScope\ValueObject\ControlStructure::BREAKING_SCOPE_NODE_TYPES);
    }
}
