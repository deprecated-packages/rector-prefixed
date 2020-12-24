<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\NodeTraverser;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
final class ClassMethodPropertyFetchManipulator
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
     * In case the property name is different to param name:
     *
     * E.g.:
     * (SomeType $anotherValue)
     * $this->value = $anotherValue;
     * ↓
     * (SomeType $anotherValue)
     */
    public function resolveParamForPropertyFetch(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod, string $propertyName) : ?\_PhpScopere8e811afab72\PhpParser\Node\Param
    {
        $assignedParamName = null;
        $this->callableNodeTraverser->traverseNodesWithCallable((array) $classMethod->stmts, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use($propertyName, &$assignedParamName) : ?int {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign) {
                return null;
            }
            if (!$this->nodeNameResolver->isName($node->var, $propertyName)) {
                return null;
            }
            if ($node->expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall || $node->expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall) {
                return null;
            }
            $assignedParamName = $this->nodeNameResolver->getName($node->expr);
            return \_PhpScopere8e811afab72\PhpParser\NodeTraverser::STOP_TRAVERSAL;
        });
        /** @var string|null $assignedParamName */
        if ($assignedParamName === null) {
            return null;
        }
        /** @var Param $param */
        foreach ((array) $classMethod->params as $param) {
            if (!$this->nodeNameResolver->isName($param, $assignedParamName)) {
                continue;
            }
            return $param;
        }
        return null;
    }
}
