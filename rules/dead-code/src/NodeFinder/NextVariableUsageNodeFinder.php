<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DeadCode\NodeFinder;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\NodeTraverser;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeNestingScope\ParentScopeFinder;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
final class NextVariableUsageNodeFinder
{
    /**
     * @var CallableNodeTraverser
     */
    private $callableNodeTraverser;
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    /**
     * @var ParentScopeFinder
     */
    private $parentScopeFinder;
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScopere8e811afab72\Rector\NodeNestingScope\ParentScopeFinder $parentScopeFinder)
    {
        $this->callableNodeTraverser = $callableNodeTraverser;
        $this->betterStandardPrinter = $betterStandardPrinter;
        $this->parentScopeFinder = $parentScopeFinder;
        $this->betterNodeFinder = $betterNodeFinder;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function find(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign $assign) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $scopeNode = $this->parentScopeFinder->find($assign);
        if ($scopeNode === null) {
            return null;
        }
        /** @var Variable $expr */
        $expr = $assign->var;
        $this->callableNodeTraverser->traverseNodesWithCallable((array) $scopeNode->stmts, function (\_PhpScopere8e811afab72\PhpParser\Node $currentNode) use($expr, &$nextUsageOfVariable) : ?int {
            // used above the assign
            if ($currentNode->getStartTokenPos() < $expr->getStartTokenPos()) {
                return null;
            }
            // skip self
            if ($currentNode === $expr) {
                return null;
            }
            if (!$this->betterStandardPrinter->areNodesEqual($currentNode, $expr)) {
                return null;
            }
            $currentNodeParent = $currentNode->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($currentNodeParent instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign && !$this->hasInParentExpression($currentNodeParent, $expr)) {
                return \_PhpScopere8e811afab72\PhpParser\NodeTraverser::STOP_TRAVERSAL;
            }
            $nextUsageOfVariable = $currentNode;
            return \_PhpScopere8e811afab72\PhpParser\NodeTraverser::STOP_TRAVERSAL;
        });
        return $nextUsageOfVariable;
    }
    private function hasInParentExpression(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign $assign, \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable $variable) : bool
    {
        $name = $this->nodeNameResolver->getName($variable);
        if ($name === null) {
            return \false;
        }
        return $this->betterNodeFinder->hasVariableOfName($assign->expr, $name);
    }
}
