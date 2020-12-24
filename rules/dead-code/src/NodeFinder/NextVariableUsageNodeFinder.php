<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DeadCode\NodeFinder;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\NodeTraverser;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoperb75b35f52b74\Rector\NodeNestingScope\ParentScopeFinder;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoperb75b35f52b74\Rector\NodeNestingScope\ParentScopeFinder $parentScopeFinder)
    {
        $this->callableNodeTraverser = $callableNodeTraverser;
        $this->betterStandardPrinter = $betterStandardPrinter;
        $this->parentScopeFinder = $parentScopeFinder;
        $this->betterNodeFinder = $betterNodeFinder;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function find(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign $assign) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $scopeNode = $this->parentScopeFinder->find($assign);
        if ($scopeNode === null) {
            return null;
        }
        /** @var Variable $expr */
        $expr = $assign->var;
        $this->callableNodeTraverser->traverseNodesWithCallable((array) $scopeNode->stmts, function (\_PhpScoperb75b35f52b74\PhpParser\Node $currentNode) use($expr, &$nextUsageOfVariable) : ?int {
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
            $currentNodeParent = $currentNode->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($currentNodeParent instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign && !$this->hasInParentExpression($currentNodeParent, $expr)) {
                return \_PhpScoperb75b35f52b74\PhpParser\NodeTraverser::STOP_TRAVERSAL;
            }
            $nextUsageOfVariable = $currentNode;
            return \_PhpScoperb75b35f52b74\PhpParser\NodeTraverser::STOP_TRAVERSAL;
        });
        return $nextUsageOfVariable;
    }
    private function hasInParentExpression(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign $assign, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable $variable) : bool
    {
        $name = $this->nodeNameResolver->getName($variable);
        if ($name === null) {
            return \false;
        }
        return $this->betterNodeFinder->hasVariableOfName($assign->expr, $name);
    }
}
