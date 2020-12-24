<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Defluent\NodeFactory;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_;
use _PhpScoperb75b35f52b74\Rector\Defluent\ValueObject\FirstAssignFluentCall;
use _PhpScoperb75b35f52b74\Rector\Defluent\ValueObject\FluentMethodCalls;
final class SeparateReturnMethodCallFactory
{
    /**
     * @return Node[]
     */
    public function createReturnFromFirstAssignFluentCallAndFluentMethodCalls(\_PhpScoperb75b35f52b74\Rector\Defluent\ValueObject\FirstAssignFluentCall $firstAssignFluentCall, \_PhpScoperb75b35f52b74\Rector\Defluent\ValueObject\FluentMethodCalls $fluentMethodCalls) : array
    {
        $nodesToAdd = [];
        if (!$firstAssignFluentCall->getAssignExpr() instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch) {
            $nodesToAdd[] = $firstAssignFluentCall->createFirstAssign();
        }
        $decoupledMethodCalls = $this->createNonFluentMethodCalls($fluentMethodCalls->getFluentMethodCalls(), $firstAssignFluentCall, \true);
        $nodesToAdd = \array_merge($nodesToAdd, $decoupledMethodCalls);
        // return the first value
        $nodesToAdd[] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_($firstAssignFluentCall->getAssignExpr());
        return $nodesToAdd;
    }
    /**
     * @param MethodCall[] $chainMethodCalls
     * @return MethodCall[]
     */
    private function createNonFluentMethodCalls(array $chainMethodCalls, \_PhpScoperb75b35f52b74\Rector\Defluent\ValueObject\FirstAssignFluentCall $firstAssignFluentCall, bool $isNewNodeNeeded) : array
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
    private function resolveMethodCallVar(\_PhpScoperb75b35f52b74\Rector\Defluent\ValueObject\FirstAssignFluentCall $firstAssignFluentCall, int $key) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr
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
