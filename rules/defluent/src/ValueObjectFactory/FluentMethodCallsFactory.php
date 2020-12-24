<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Defluent\ValueObjectFactory;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall;
use _PhpScoper2a4e7ab1ecbc\Rector\Defluent\NodeAnalyzer\FluentChainMethodCallNodeAnalyzer;
use _PhpScoper2a4e7ab1ecbc\Rector\Defluent\NodeAnalyzer\SameClassMethodCallAnalyzer;
use _PhpScoper2a4e7ab1ecbc\Rector\Defluent\ValueObject\FluentMethodCalls;
final class FluentMethodCallsFactory
{
    /**
     * @var FluentChainMethodCallNodeAnalyzer
     */
    private $fluentChainMethodCallNodeAnalyzer;
    /**
     * @var SameClassMethodCallAnalyzer
     */
    private $sameClassMethodCallAnalyzer;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Defluent\NodeAnalyzer\FluentChainMethodCallNodeAnalyzer $fluentChainMethodCallNodeAnalyzer, \_PhpScoper2a4e7ab1ecbc\Rector\Defluent\NodeAnalyzer\SameClassMethodCallAnalyzer $sameClassMethodCallAnalyzer)
    {
        $this->fluentChainMethodCallNodeAnalyzer = $fluentChainMethodCallNodeAnalyzer;
        $this->sameClassMethodCallAnalyzer = $sameClassMethodCallAnalyzer;
    }
    public function createFromLastMethodCall(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall $lastMethodCall) : ?\_PhpScoper2a4e7ab1ecbc\Rector\Defluent\ValueObject\FluentMethodCalls
    {
        $chainMethodCalls = $this->fluentChainMethodCallNodeAnalyzer->collectAllMethodCallsInChain($lastMethodCall);
        if (!$this->sameClassMethodCallAnalyzer->haveSingleClass($chainMethodCalls)) {
            return null;
        }
        // we need at least 2 method call for fluent
        if (\count($chainMethodCalls) < 2) {
            return null;
        }
        $rootMethodCall = $this->resolveRootMethodCall($chainMethodCalls);
        return new \_PhpScoper2a4e7ab1ecbc\Rector\Defluent\ValueObject\FluentMethodCalls($rootMethodCall, $chainMethodCalls, $lastMethodCall);
    }
    /**
     * @param MethodCall[] $chainMethodCalls
     */
    private function resolveRootMethodCall(array $chainMethodCalls) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall
    {
        $lastKey = \array_key_last($chainMethodCalls);
        return $chainMethodCalls[$lastKey];
    }
}
