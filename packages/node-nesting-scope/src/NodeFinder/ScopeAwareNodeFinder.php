<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeNestingScope\NodeFinder;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScopere8e811afab72\Rector\NodeNestingScope\ValueObject\ControlStructure;
final class ScopeAwareNodeFinder
{
    /**
     * @var bool
     */
    private $isBreakingNodeFoundFirst = \false;
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder)
    {
        $this->betterNodeFinder = $betterNodeFinder;
    }
    /**
     * Find node based on $callable or null, when the nesting scope is broken
     * @param class-string[] $allowedTypes
     */
    public function findParentType(\_PhpScopere8e811afab72\PhpParser\Node $node, array $allowedTypes) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $callable = function (\_PhpScopere8e811afab72\PhpParser\Node $node) use($allowedTypes) : bool {
            foreach ($allowedTypes as $allowedType) {
                if (!\is_a($node, $allowedType)) {
                    continue;
                }
                return \true;
            }
            return \false;
        };
        return $this->findParent($node, $callable, $allowedTypes);
    }
    /**
     * Find node based on $callable or null, when the nesting scope is broken
     * @param class-string[] $allowedTypes
     */
    public function findParent(\_PhpScopere8e811afab72\PhpParser\Node $node, callable $callable, array $allowedTypes) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $parentNestingBreakTypes = \array_diff(\_PhpScopere8e811afab72\Rector\NodeNestingScope\ValueObject\ControlStructure::BREAKING_SCOPE_NODE_TYPES, $allowedTypes);
        $this->isBreakingNodeFoundFirst = \false;
        $foundNode = $this->betterNodeFinder->findFirstPrevious($node, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use($callable, $parentNestingBreakTypes) : bool {
            if ($callable($node)) {
                return \true;
            }
            foreach ($parentNestingBreakTypes as $parentNestingBreakType) {
                if (\is_a($node, $parentNestingBreakType, \true)) {
                    $this->isBreakingNodeFoundFirst = \true;
                    return \true;
                }
            }
            return \false;
        });
        if ($this->isBreakingNodeFoundFirst) {
            return null;
        }
        return $foundNode;
    }
}
