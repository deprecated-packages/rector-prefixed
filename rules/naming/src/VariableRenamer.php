<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Naming;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Closure;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\FunctionLike;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScopere8e811afab72\Rector\Naming\PhpDoc\VarTagValueNodeRenamer;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
final class VariableRenamer
{
    /**
     * @var CallableNodeTraverser
     */
    private $callableNodeTraverser;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var VarTagValueNodeRenamer
     */
    private $varTagValueNodeRenamer;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScopere8e811afab72\Rector\Naming\PhpDoc\VarTagValueNodeRenamer $varTagValueNodeRenamer)
    {
        $this->callableNodeTraverser = $callableNodeTraverser;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->varTagValueNodeRenamer = $varTagValueNodeRenamer;
    }
    /**
     * @param ClassMethod|Function_|Closure $functionLike
     */
    public function renameVariableInFunctionLike(\_PhpScopere8e811afab72\PhpParser\Node\FunctionLike $functionLike, ?\_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign $assign = null, string $oldName, string $expectedName) : void
    {
        $isRenamingActive = \false;
        if ($assign === null) {
            $isRenamingActive = \true;
        }
        $this->callableNodeTraverser->traverseNodesWithCallable((array) $functionLike->stmts, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use($oldName, $expectedName, $assign, &$isRenamingActive) : ?Variable {
            if ($assign !== null && $node === $assign) {
                $isRenamingActive = \true;
                return null;
            }
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable) {
                return null;
            }
            // skip param names
            $parent = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($parent instanceof \_PhpScopere8e811afab72\PhpParser\Node\Param) {
                return null;
            }
            // TODO: Remove in next PR (with above param check?),
            // TODO: Should be implemented in BreakingVariableRenameGuard::shouldSkipParam()
            if ($this->isParamInParentFunction($node)) {
                return null;
            }
            if (!$isRenamingActive) {
                return null;
            }
            return $this->renameVariableIfMatchesName($node, $oldName, $expectedName);
        });
    }
    private function isParamInParentFunction(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable $variable) : bool
    {
        /** @var Closure|null $closure */
        $closure = $variable->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLOSURE_NODE);
        if ($closure === null) {
            return \false;
        }
        $variableName = $this->nodeNameResolver->getName($variable);
        if ($variableName === null) {
            return \false;
        }
        foreach ($closure->params as $param) {
            if ($this->nodeNameResolver->isName($param, $variableName)) {
                return \true;
            }
        }
        return \false;
    }
    private function renameVariableIfMatchesName(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable $variable, string $oldName, string $expectedName) : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable
    {
        if (!$this->nodeNameResolver->isName($variable, $oldName)) {
            return null;
        }
        $variable->name = $expectedName;
        $this->varTagValueNodeRenamer->renameAssignVarTagVariableName($variable, $oldName, $expectedName);
        return $variable;
    }
}
