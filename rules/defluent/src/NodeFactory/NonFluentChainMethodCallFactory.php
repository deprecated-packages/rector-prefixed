<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Defluent\NodeFactory;

use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\New_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Defluent\NodeAnalyzer\FluentChainMethodCallNodeAnalyzer;
use _PhpScopere8e811afab72\Rector\Defluent\ValueObject\AssignAndRootExpr;
use _PhpScopere8e811afab72\Rector\Defluent\ValueObject\FluentCallsKind;
use _PhpScopere8e811afab72\Rector\NetteKdyby\Naming\VariableNaming;
final class NonFluentChainMethodCallFactory
{
    /**
     * @var FluentChainMethodCallNodeAnalyzer
     */
    private $fluentChainMethodCallNodeAnalyzer;
    /**
     * @var VariableNaming
     */
    private $variableNaming;
    public function __construct(\_PhpScopere8e811afab72\Rector\Defluent\NodeAnalyzer\FluentChainMethodCallNodeAnalyzer $fluentChainMethodCallNodeAnalyzer, \_PhpScopere8e811afab72\Rector\NetteKdyby\Naming\VariableNaming $variableNaming)
    {
        $this->fluentChainMethodCallNodeAnalyzer = $fluentChainMethodCallNodeAnalyzer;
        $this->variableNaming = $variableNaming;
    }
    /**
     * @return Expression[]
     */
    public function createFromNewAndRootMethodCall(\_PhpScopere8e811afab72\PhpParser\Node\Expr\New_ $new, \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $rootMethodCall) : array
    {
        $variableName = $this->variableNaming->resolveFromNode($new);
        if ($variableName === null) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        $newVariable = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable($variableName);
        $newStmts = [];
        $newStmts[] = $this->createAssignExpression($newVariable, $new);
        // resolve chain calls
        $chainMethodCalls = $this->fluentChainMethodCallNodeAnalyzer->collectAllMethodCallsInChainWithoutRootOne($rootMethodCall);
        $chainMethodCalls = \array_reverse($chainMethodCalls);
        foreach ($chainMethodCalls as $chainMethodCall) {
            $methodCall = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall($newVariable, $chainMethodCall->name, $chainMethodCall->args);
            $newStmts[] = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression($methodCall);
        }
        return $newStmts;
    }
    /**
     * @param MethodCall[] $chainMethodCalls
     * @return Assign[]|MethodCall[]|Return_[]
     */
    public function createFromAssignObjectAndMethodCalls(\_PhpScopere8e811afab72\Rector\Defluent\ValueObject\AssignAndRootExpr $assignAndRootExpr, array $chainMethodCalls, string $kind) : array
    {
        $nodesToAdd = [];
        $isNewNodeNeeded = $this->isNewNodeNeeded($assignAndRootExpr);
        if ($isNewNodeNeeded) {
            $nodesToAdd[] = $assignAndRootExpr->createFirstAssign();
        }
        $decoupledMethodCalls = $this->createNonFluentMethodCalls($chainMethodCalls, $assignAndRootExpr, $isNewNodeNeeded);
        $nodesToAdd = \array_merge($nodesToAdd, $decoupledMethodCalls);
        if ($assignAndRootExpr->getSilentVariable() !== null && $kind !== \_PhpScopere8e811afab72\Rector\Defluent\ValueObject\FluentCallsKind::IN_ARGS) {
            $nodesToAdd[] = $assignAndRootExpr->getReturnSilentVariable();
        }
        return $nodesToAdd;
    }
    private function createAssignExpression(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable $newVariable, \_PhpScopere8e811afab72\PhpParser\Node\Expr\New_ $new) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression
    {
        $assign = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign($newVariable, $new);
        return new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression($assign);
    }
    private function isNewNodeNeeded(\_PhpScopere8e811afab72\Rector\Defluent\ValueObject\AssignAndRootExpr $assignAndRootExpr) : bool
    {
        if ($assignAndRootExpr->isFirstCallFactory()) {
            return \true;
        }
        if ($assignAndRootExpr->getRootExpr() === $assignAndRootExpr->getAssignExpr()) {
            return \false;
        }
        return $assignAndRootExpr->getRootExpr() instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\New_;
    }
    /**
     * @param MethodCall[] $chainMethodCalls
     * @return Assign[]|MethodCall[]
     */
    private function createNonFluentMethodCalls(array $chainMethodCalls, \_PhpScopere8e811afab72\Rector\Defluent\ValueObject\AssignAndRootExpr $assignAndRootExpr, bool $isNewNodeNeeded) : array
    {
        $decoupledMethodCalls = [];
        $lastKey = \array_key_last($chainMethodCalls);
        foreach ($chainMethodCalls as $key => $chainMethodCall) {
            // skip first, already handled
            if ($key === $lastKey && $assignAndRootExpr->isFirstCallFactory() && $isNewNodeNeeded) {
                continue;
            }
            $var = $this->resolveMethodCallVar($assignAndRootExpr, $key);
            $chainMethodCall->var = $var;
            $decoupledMethodCalls[] = $chainMethodCall;
        }
        if ($assignAndRootExpr->getRootExpr() instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\New_ && $assignAndRootExpr->getSilentVariable() !== null) {
            $decoupledMethodCalls[] = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign($assignAndRootExpr->getSilentVariable(), $assignAndRootExpr->getRootExpr());
        }
        return \array_reverse($decoupledMethodCalls);
    }
    private function resolveMethodCallVar(\_PhpScopere8e811afab72\Rector\Defluent\ValueObject\AssignAndRootExpr $assignAndRootExpr, int $key) : \_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        if (!$assignAndRootExpr->isFirstCallFactory()) {
            return $assignAndRootExpr->getCallerExpr();
        }
        // very first call
        if ($key !== 0) {
            return $assignAndRootExpr->getCallerExpr();
        }
        return $assignAndRootExpr->getFactoryAssignVariable();
    }
}
