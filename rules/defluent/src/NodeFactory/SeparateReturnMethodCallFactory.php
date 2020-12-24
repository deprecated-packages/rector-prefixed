<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Defluent\NodeFactory;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_;
use _PhpScoper0a6b37af0871\Rector\Defluent\ValueObject\FirstAssignFluentCall;
use _PhpScoper0a6b37af0871\Rector\Defluent\ValueObject\FluentMethodCalls;
final class SeparateReturnMethodCallFactory
{
    /**
     * @return Node[]
     */
    public function createReturnFromFirstAssignFluentCallAndFluentMethodCalls(\_PhpScoper0a6b37af0871\Rector\Defluent\ValueObject\FirstAssignFluentCall $firstAssignFluentCall, \_PhpScoper0a6b37af0871\Rector\Defluent\ValueObject\FluentMethodCalls $fluentMethodCalls) : array
    {
        $nodesToAdd = [];
        if (!$firstAssignFluentCall->getAssignExpr() instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch) {
            $nodesToAdd[] = $firstAssignFluentCall->createFirstAssign();
        }
        $decoupledMethodCalls = $this->createNonFluentMethodCalls($fluentMethodCalls->getFluentMethodCalls(), $firstAssignFluentCall, \true);
        $nodesToAdd = \array_merge($nodesToAdd, $decoupledMethodCalls);
        // return the first value
        $nodesToAdd[] = new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_($firstAssignFluentCall->getAssignExpr());
        return $nodesToAdd;
    }
    /**
     * @param MethodCall[] $chainMethodCalls
     * @return MethodCall[]
     */
    private function createNonFluentMethodCalls(array $chainMethodCalls, \_PhpScoper0a6b37af0871\Rector\Defluent\ValueObject\FirstAssignFluentCall $firstAssignFluentCall, bool $isNewNodeNeeded) : array
    {
        $decoupledMethodCalls = [];
        $lastKey = \array_key_last($chainMethodCalls);
        foreach ($chainMethodCalls as $key => $chainMethodCall) {
            // skip first, already handled
            if ($key === $lastKey && $firstAssignFluentCall->isFirstCallFactory() && $isNewNodeNeeded) {
                continue;
            }
            $chainMethodCall->var = $this->resolveMethodCallVar($firstAssignFluentCall, $key);
            $decoupledMethodCalls[] = $chainMethodCall;
        }
        return \array_reverse($decoupledMethodCalls);
    }
    private function resolveMethodCallVar(\_PhpScoper0a6b37af0871\Rector\Defluent\ValueObject\FirstAssignFluentCall $firstAssignFluentCall, int $key) : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr
    {
        if (!$firstAssignFluentCall->isFirstCallFactory()) {
            return $firstAssignFluentCall->getCallerExpr();
        }
        // very first call
        if ($key !== 0) {
            return $firstAssignFluentCall->getCallerExpr();
        }
        return $firstAssignFluentCall->getFactoryAssignVariable();
    }
}
