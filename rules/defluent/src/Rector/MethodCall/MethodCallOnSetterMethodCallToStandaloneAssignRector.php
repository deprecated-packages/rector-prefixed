<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Defluent\Rector\MethodCall;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Arg;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\Rector\Defluent\NodeAnalyzer\NewFluentChainMethodCallNodeAnalyzer;
use _PhpScoper0a6b37af0871\Rector\Defluent\NodeFactory\VariableFromNewFactory;
use _PhpScoper0a6b37af0871\Rector\Defluent\Rector\AbstractFluentChainMethodCallRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://amateri.com for sponsoring this rule - visit them on https://www.startupjobs.cz/startup/scrumworks-s-r-o
 *
 * @see \Rector\Defluent\Tests\Rector\MethodCall\MethodCallOnSetterMethodCallToStandaloneAssignRector\MethodCallOnSetterMethodCallToStandaloneAssignRectorTest
 */
final class MethodCallOnSetterMethodCallToStandaloneAssignRector extends \_PhpScoper0a6b37af0871\Rector\Defluent\Rector\AbstractFluentChainMethodCallRector
{
    /**
     * @var NewFluentChainMethodCallNodeAnalyzer
     */
    private $newFluentChainMethodCallNodeAnalyzer;
    /**
     * @var VariableFromNewFactory
     */
    private $variableFromNewFactory;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Defluent\NodeAnalyzer\NewFluentChainMethodCallNodeAnalyzer $newFluentChainMethodCallNodeAnalyzer, \_PhpScoper0a6b37af0871\Rector\Defluent\NodeFactory\VariableFromNewFactory $variableFromNewFactory)
    {
        $this->newFluentChainMethodCallNodeAnalyzer = $newFluentChainMethodCallNodeAnalyzer;
        $this->variableFromNewFactory = $variableFromNewFactory;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change method call on setter to standalone assign before the setter', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function some()
    {
        $this->anotherMethod(new AnotherClass())
            ->someFunction();
    }

    public function anotherMethod(AnotherClass $anotherClass)
    {
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function some()
    {
        $anotherClass = new AnotherClass();
        $anotherClass->someFunction();
        $this->anotherMethod($anotherClass);
    }

    public function anotherMethod(AnotherClass $anotherClass)
    {
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if ($this->shouldSkipMethodCall($node)) {
            return null;
        }
        $rootMethodCall = $this->fluentChainMethodCallNodeAnalyzer->resolveRootMethodCall($node);
        if ($rootMethodCall === null) {
            return null;
        }
        $new = $this->newFluentChainMethodCallNodeAnalyzer->matchNewInFluentSetterMethodCall($rootMethodCall);
        if ($new === null) {
            return null;
        }
        $newStmts = $this->nonFluentChainMethodCallFactory->createFromNewAndRootMethodCall($new, $node);
        $this->addNodesBeforeNode($newStmts, $node);
        // change new arg to root variable
        $newVariable = $this->variableFromNewFactory->create($new);
        $rootMethodCall->args = [new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg($newVariable)];
        return $rootMethodCall;
    }
}
