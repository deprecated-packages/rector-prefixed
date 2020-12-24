<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\DeadCode\NodeFinder;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\PhpParser\NodeTraverser;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeNestingScope\ParentScopeFinder;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper2a4e7ab1ecbc\Rector\NodeNestingScope\ParentScopeFinder $parentScopeFinder)
    {
        $this->callableNodeTraverser = $callableNodeTraverser;
        $this->betterStandardPrinter = $betterStandardPrinter;
        $this->parentScopeFinder = $parentScopeFinder;
        $this->betterNodeFinder = $betterNodeFinder;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function find(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign $assign) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        $scopeNode = $this->parentScopeFinder->find($assign);
        if ($scopeNode === null) {
            return null;
        }
        /** @var Variable $expr */
        $expr = $assign->var;
        $this->callableNodeTraverser->traverseNodesWithCallable((array) $scopeNode->stmts, function (\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $currentNode) use($expr, &$nextUsageOfVariable) : ?int {
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
            $currentNodeParent = $currentNode->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($currentNodeParent instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign && !$this->hasInParentExpression($currentNodeParent, $expr)) {
                return \_PhpScoper2a4e7ab1ecbc\PhpParser\NodeTraverser::STOP_TRAVERSAL;
            }
            $nextUsageOfVariable = $currentNode;
            return \_PhpScoper2a4e7ab1ecbc\PhpParser\NodeTraverser::STOP_TRAVERSAL;
        });
        return $nextUsageOfVariable;
    }
    private function hasInParentExpression(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign $assign, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable $variable) : bool
    {
        $name = $this->nodeNameResolver->getName($variable);
        if ($name === null) {
            return \false;
        }
        return $this->betterNodeFinder->hasVariableOfName($assign->expr, $name);
    }
}
