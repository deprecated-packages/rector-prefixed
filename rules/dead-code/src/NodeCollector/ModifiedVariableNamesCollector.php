<?php

declare (strict_types=1);
namespace Rector\DeadCode\NodeCollector;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\Variable;
use Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
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
    public function __construct(\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->callableNodeTraverser = $callableNodeTraverser;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @return string[]
     */
    public function collectModifiedVariableNames(\PhpParser\Node $node) : array
    {
        $modifiedVariableNames = [];
        $this->callableNodeTraverser->traverseNodesWithCallable($node, function (\PhpParser\Node $node) use(&$modifiedVariableNames) {
            if ($this->isVariableOverriddenInAssign($node)) {
                /** @var Assign $node */
                $variableName = $this->nodeNameResolver->getName($node->var);
                if ($variableName === null) {
                    return null;
                }
                $modifiedVariableNames[] = $variableName;
            }
            if ($this->isVariableChangedInReference($node)) {
                /** @var Arg $node */
                $variableName = $this->nodeNameResolver->getName($node->value);
                if ($variableName === null) {
                    return null;
                }
                $modifiedVariableNames[] = $variableName;
            }
        });
        return $modifiedVariableNames;
    }
    private function isVariableOverriddenInAssign(\PhpParser\Node $node) : bool
    {
        if (!$node instanceof \PhpParser\Node\Expr\Assign) {
            return \false;
        }
        return $node->var instanceof \PhpParser\Node\Expr\Variable;
    }
    private function isVariableChangedInReference(\PhpParser\Node $node) : bool
    {
        if (!$node instanceof \PhpParser\Node\Arg) {
            return \false;
        }
        $parentNode = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentNode instanceof \PhpParser\Node\Expr\FuncCall) {
            return \false;
        }
        return $this->nodeNameResolver->isNames($parentNode, ['array_shift', 'array_pop']);
    }
}
