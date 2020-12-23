<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\DeadCode\NodeCollector;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Arg;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
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
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->callableNodeTraverser = $callableNodeTraverser;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @return string[]
     */
    public function collectModifiedVariableNames(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt $stmt) : array
    {
        $argNames = $this->collectFromArgs($stmt);
        $assignNames = $this->collectFromAssigns($stmt);
        return \array_merge($argNames, $assignNames);
    }
    /**
     * @return string[]
     */
    private function collectFromArgs(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt $stmt) : array
    {
        $variableNames = [];
        $this->callableNodeTraverser->traverseNodesWithCallable($stmt, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) use(&$variableNames) {
            if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg) {
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
    private function collectFromAssigns(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt $stmt) : array
    {
        $modifiedVariableNames = [];
        $this->callableNodeTraverser->traverseNodesWithCallable($stmt, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) use(&$modifiedVariableNames) {
            if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign) {
                return null;
            }
            if (!$node->var instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable) {
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
    private function isVariableChangedInReference(\_PhpScoper0a2ac50786fa\PhpParser\Node\Arg $arg) : bool
    {
        $parentNode = $arg->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall) {
            return \false;
        }
        return $this->nodeNameResolver->isNames($parentNode, ['array_shift', 'array_pop']);
    }
}
