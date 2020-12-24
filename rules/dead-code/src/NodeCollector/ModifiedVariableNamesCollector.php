<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DeadCode\NodeCollector;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
final class ModifiedVariableNamesCollector
{
    /**
     * @var CallableNodeTraverser
     */
    private $callableNodeTraverser;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->callableNodeTraverser = $callableNodeTraverser;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @return string[]
     */
    public function collectModifiedVariableNames(\_PhpScopere8e811afab72\PhpParser\Node\Stmt $stmt) : array
    {
        $argNames = $this->collectFromArgs($stmt);
        $assignNames = $this->collectFromAssigns($stmt);
        return \array_merge($argNames, $assignNames);
    }
    /**
     * @return string[]
     */
    private function collectFromArgs(\_PhpScopere8e811afab72\PhpParser\Node\Stmt $stmt) : array
    {
        $variableNames = [];
        $this->callableNodeTraverser->traverseNodesWithCallable($stmt, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use(&$variableNames) {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Arg) {
                return null;
            }
            if (!$this->isVariableChangedInReference($node)) {
                return null;
            }
            $variableName = $this->nodeNameResolver->getName($node->value);
            if ($variableName === null) {
                return null;
            }
            $variableNames[] = $variableName;
        });
        return $variableNames;
    }
    /**
     * @return string[]
     */
    private function collectFromAssigns(\_PhpScopere8e811afab72\PhpParser\Node\Stmt $stmt) : array
    {
        $modifiedVariableNames = [];
        $this->callableNodeTraverser->traverseNodesWithCallable($stmt, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use(&$modifiedVariableNames) {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign) {
                return null;
            }
            if (!$node->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable) {
                return null;
            }
            $variableName = $this->nodeNameResolver->getName($node->var);
            if ($variableName === null) {
                return null;
            }
            $modifiedVariableNames[] = $variableName;
        });
        return $modifiedVariableNames;
    }
    private function isVariableChangedInReference(\_PhpScopere8e811afab72\PhpParser\Node\Arg $arg) : bool
    {
        $parentNode = $arg->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall) {
            return \false;
        }
        return $this->nodeNameResolver->isNames($parentNode, ['array_shift', 'array_pop']);
    }
}
