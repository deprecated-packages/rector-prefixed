<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Naming;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Closure;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Function_;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScoperb75b35f52b74\Rector\Naming\PhpDoc\VarTagValueNodeRenamer;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoperb75b35f52b74\Rector\Naming\PhpDoc\VarTagValueNodeRenamer $varTagValueNodeRenamer)
    {
        $this->callableNodeTraverser = $callableNodeTraverser;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->varTagValueNodeRenamer = $varTagValueNodeRenamer;
    }
    /**
     * @param ClassMethod|Function_|Closure $functionLike
     */
    public function renameVariableInFunctionLike(\_PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike $functionLike, ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign $assign = null, string $oldName, string $expectedName) : void
    {
        $isRenamingActive = \false;
        if ($assign === null) {
            $isRenamingActive = \true;
        }
        $this->callableNodeTraverser->traverseNodesWithCallable((array) $functionLike->stmts, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use($oldName, $expectedName, $assign, &$isRenamingActive) : ?Variable {
            if ($assign !== null && $node === $assign) {
                $isRenamingActive = \true;
                return null;
            }
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable) {
                return null;
            }
            // skip param names
            $parent = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($parent instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Param) {
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
    private function isParamInParentFunction(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable $variable) : bool
    {
        /** @var Closure|null $closure */
        $closure = $variable->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLOSURE_NODE);
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
    private function renameVariableIfMatchesName(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable $variable, string $oldName, string $expectedName) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable
    {
        if (!$this->nodeNameResolver->isName($variable, $oldName)) {
            return null;
        }
        $variable->name = $expectedName;
        $this->varTagValueNodeRenamer->renameAssignVarTagVariableName($variable, $oldName, $expectedName);
        return $variable;
    }
}
