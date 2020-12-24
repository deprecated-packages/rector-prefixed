<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
final class PropertyFetchAssignManipulator
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var CallableNodeTraverser
     */
    private $callableNodeTraverser;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->callableNodeTraverser = $callableNodeTraverser;
    }
    /**
     * @return string[]
     */
    public function getPropertyNamesOfAssignOfVariable(\_PhpScopere8e811afab72\PhpParser\Node $node, string $paramName) : array
    {
        $propertyNames = [];
        $this->callableNodeTraverser->traverseNodesWithCallable($node, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use($paramName, &$propertyNames) {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign) {
                return null;
            }
            if (!$this->isVariableAssignToThisPropertyFetch($node, $paramName)) {
                return null;
            }
            /** @var Assign $node */
            $propertyName = $this->nodeNameResolver->getName($node->expr);
            if ($propertyName) {
                $propertyNames[] = $propertyName;
            }
            return null;
        });
        return $propertyNames;
    }
    /**
     * Matches:
     * "$this->someValue = $<variableName>;"
     */
    private function isVariableAssignToThisPropertyFetch(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign $assign, string $variableName) : bool
    {
        if (!$assign->expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable) {
            return \false;
        }
        if (!$this->nodeNameResolver->isName($assign->expr, $variableName)) {
            return \false;
        }
        if (!$assign->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch) {
            return \false;
        }
        $propertyFetch = $assign->var;
        // must be local property
        return $this->nodeNameResolver->isName($propertyFetch->var, 'this');
    }
}
