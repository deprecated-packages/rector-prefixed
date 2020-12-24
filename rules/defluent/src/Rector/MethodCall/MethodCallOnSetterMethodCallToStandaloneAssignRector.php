<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Defluent\Rector\MethodCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\Rector\Defluent\NodeAnalyzer\NewFluentChainMethodCallNodeAnalyzer;
use _PhpScopere8e811afab72\Rector\Defluent\NodeFactory\VariableFromNewFactory;
use _PhpScopere8e811afab72\Rector\Defluent\Rector\AbstractFluentChainMethodCallRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://amateri.com for sponsoring this rule - visit them on https://www.startupjobs.cz/startup/scrumworks-s-r-o
 *
 * @see \Rector\Defluent\Tests\Rector\MethodCall\MethodCallOnSetterMethodCallToStandaloneAssignRector\MethodCallOnSetterMethodCallToStandaloneAssignRectorTest
 */
final class MethodCallOnSetterMethodCallToStandaloneAssignRector extends \_PhpScopere8e811afab72\Rector\Defluent\Rector\AbstractFluentChainMethodCallRector
{
    /**
     * @var NewFluentChainMethodCallNodeAnalyzer
     */
    private $newFluentChainMethodCallNodeAnalyzer;
    /**
     * @var VariableFromNewFactory
     */
    private $variableFromNewFactory;
    public function __construct(\_PhpScopere8e811afab72\Rector\Defluent\NodeAnalyzer\NewFluentChainMethodCallNodeAnalyzer $newFluentChainMethodCallNodeAnalyzer, \_PhpScopere8e811afab72\Rector\Defluent\NodeFactory\VariableFromNewFactory $variableFromNewFactory)
    {
        $this->newFluentChainMethodCallNodeAnalyzer = $newFluentChainMethodCallNodeAnalyzer;
        $this->variableFromNewFactory = $variableFromNewFactory;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change method call on setter to standalone assign before the setter', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
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
        $rootMethodCall->args = [new \_PhpScopere8e811afab72\PhpParser\Node\Arg($newVariable)];
        return $rootMethodCall;
    }
}
