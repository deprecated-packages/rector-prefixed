<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DeadCode\NodeCollector;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->callableNodeTraverser = $callableNodeTraverser;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @return string[]
     */
    public function collectModifiedVariableNames(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt $stmt) : array
    {
        $argNames = $this->collectFromArgs($stmt);
        $assignNames = $this->collectFromAssigns($stmt);
        return \array_merge($argNames, $assignNames);
    }
    /**
     * @return string[]
     */
    private function collectFromArgs(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt $stmt) : array
    {
        $variableNames = [];
        $this->callableNodeTraverser->traverseNodesWithCallable($stmt, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use(&$variableNames) {
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Arg) {
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
    private function collectFromAssigns(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt $stmt) : array
    {
        $modifiedVariableNames = [];
        $this->callableNodeTraverser->traverseNodesWithCallable($stmt, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use(&$modifiedVariableNames) {
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
                return null;
            }
            if (!$node->var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable) {
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
    private function isVariableChangedInReference(\_PhpScoperb75b35f52b74\PhpParser\Node\Arg $arg) : bool
    {
        $parentNode = $arg->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall) {
            return \false;
        }
        return $this->nodeNameResolver->isNames($parentNode, ['array_shift', 'array_pop']);
    }
}
