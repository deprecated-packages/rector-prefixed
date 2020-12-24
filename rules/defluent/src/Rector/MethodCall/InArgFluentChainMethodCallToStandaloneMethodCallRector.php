<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Defluent\Rector\MethodCall;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\Rector\Defluent\NodeAnalyzer\NewFluentChainMethodCallNodeAnalyzer;
use _PhpScoperb75b35f52b74\Rector\Defluent\NodeFactory\VariableFromNewFactory;
use _PhpScoperb75b35f52b74\Rector\Defluent\Rector\AbstractFluentChainMethodCallRector;
use _PhpScoperb75b35f52b74\Rector\Defluent\ValueObject\FluentCallsKind;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://amateri.com for sponsoring this rule - visit them on https://www.startupjobs.cz/startup/scrumworks-s-r-o
 *
 * @see \Rector\Defluent\Tests\Rector\MethodCall\InArgChainFluentMethodCallToStandaloneMethodCallRectorTest\InArgChainFluentMethodCallToStandaloneMethodCallRectorTest
 */
final class InArgFluentChainMethodCallToStandaloneMethodCallRector extends \_PhpScoperb75b35f52b74\Rector\Defluent\Rector\AbstractFluentChainMethodCallRector
{
    /**
     * @var NewFluentChainMethodCallNodeAnalyzer
     */
    private $newFluentChainMethodCallNodeAnalyzer;
    /**
     * @var VariableFromNewFactory
     */
    private $variableFromNewFactory;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Defluent\NodeAnalyzer\NewFluentChainMethodCallNodeAnalyzer $newFluentChainMethodCallNodeAnalyzer, \_PhpScoperb75b35f52b74\Rector\Defluent\NodeFactory\VariableFromNewFactory $variableFromNewFactory)
    {
        $this->newFluentChainMethodCallNodeAnalyzer = $newFluentChainMethodCallNodeAnalyzer;
        $this->variableFromNewFactory = $variableFromNewFactory;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns fluent interface calls to classic ones.', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class UsedAsParameter
{
    public function someFunction(FluentClass $someClass)
    {
        $this->processFluentClass($someClass->someFunction()->otherFunction());
    }

    public function processFluentClass(FluentClass $someClass)
    {
    }
}

CODE_SAMPLE
, <<<'CODE_SAMPLE'
class UsedAsParameter
{
    public function someFunction(FluentClass $someClass)
    {
        $someClass->someFunction();
        $someClass->otherFunction();
        $this->processFluentClass($someClass);
    }

    public function processFluentClass(FluentClass $someClass)
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$this->hasParentType($node, \_PhpScoperb75b35f52b74\PhpParser\Node\Arg::class)) {
            return null;
        }
        /** @var Arg $arg */
        $arg = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        /** @var Node|null $parentMethodCall */
        $parentMethodCall = $arg->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentMethodCall instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall) {
            return null;
        }
        if (!$this->fluentChainMethodCallNodeAnalyzer->isLastChainMethodCall($node)) {
            return null;
        }
        // create instances from (new ...)->call, re-use from
        if ($node->var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_) {
            $this->refactorNew($node, $node->var);
            return null;
        }
        $assignAndRootExprAndNodesToAdd = $this->createStandaloneNodesToAddFromChainMethodCalls($node, \_PhpScoperb75b35f52b74\Rector\Defluent\ValueObject\FluentCallsKind::IN_ARGS);
        if ($assignAndRootExprAndNodesToAdd === null) {
            return null;
        }
        $this->addNodesBeforeNode($assignAndRootExprAndNodesToAdd->getNodesToAdd(), $node);
        return $assignAndRootExprAndNodesToAdd->getRootCallerExpr();
    }
    private function refactorNew(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_ $new) : void
    {
        if (!$this->newFluentChainMethodCallNodeAnalyzer->isNewMethodCallReturningSelf($methodCall)) {
            return;
        }
        $nodesToAdd = $this->nonFluentChainMethodCallFactory->createFromNewAndRootMethodCall($new, $methodCall);
        $newVariable = $this->variableFromNewFactory->create($new);
        $nodesToAdd[] = $this->createFluentAsArg($methodCall, $newVariable);
        $this->addNodesBeforeNode($nodesToAdd, $methodCall);
        $this->removeParentParent($methodCall);
    }
    /**
     * @deprecated
     * @todo extact to factory
     */
    private function createFluentAsArg(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable $variable) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall
    {
        /** @var Arg $parent */
        $parent = $methodCall->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        /** @var MethodCall $parentParent */
        $parentParent = $parent->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        $lastMethodCall = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall($parentParent->var, $parentParent->name);
        $lastMethodCall->args[] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Arg($variable);
        return $lastMethodCall;
    }
    private function removeParentParent(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall) : void
    {
        /** @var Arg $parent */
        $parent = $methodCall->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        /** @var MethodCall $parentParent */
        $parentParent = $parent->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        $this->removeNode($parentParent);
    }
}
