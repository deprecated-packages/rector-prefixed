<?php

declare (strict_types=1);
namespace Rector\Defluent\Rector\MethodCall;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\Variable;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Defluent\NodeAnalyzer\NewFluentChainMethodCallNodeAnalyzer;
use Rector\Defluent\Rector\AbstractFluentChainMethodCallRector;
use Rector\Defluent\ValueObject\FluentCallsKind;
use Rector\NetteKdyby\Naming\VariableNaming;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://amateri.com for sponsoring this rule - visit them on https://www.startupjobs.cz/startup/scrumworks-s-r-o
 *
 * @see \Rector\Defluent\Tests\Rector\MethodCall\InArgChainFluentMethodCallToStandaloneMethodCallRectorTest\InArgChainFluentMethodCallToStandaloneMethodCallRectorTest
 */
final class InArgFluentChainMethodCallToStandaloneMethodCallRector extends \Rector\Defluent\Rector\AbstractFluentChainMethodCallRector
{
    /**
     * @var VariableNaming
     */
    private $variableNaming;
    /**
     * @var NewFluentChainMethodCallNodeAnalyzer
     */
    private $newFluentChainMethodCallNodeAnalyzer;
    public function __construct(\Rector\NetteKdyby\Naming\VariableNaming $variableNaming, \Rector\Defluent\NodeAnalyzer\NewFluentChainMethodCallNodeAnalyzer $newFluentChainMethodCallNodeAnalyzer)
    {
        $this->variableNaming = $variableNaming;
        $this->newFluentChainMethodCallNodeAnalyzer = $newFluentChainMethodCallNodeAnalyzer;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns fluent interface calls to classic ones.', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->hasParentType($node, \PhpParser\Node\Arg::class)) {
            return null;
        }
        /** @var Arg $arg */
        $arg = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        /** @var Node|null $parentMethodCall */
        $parentMethodCall = $arg->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentMethodCall instanceof \PhpParser\Node\Expr\MethodCall) {
            return null;
        }
        if (!$this->fluentChainMethodCallNodeAnalyzer->isLastChainMethodCall($node)) {
            return null;
        }
        // create instances from (new ...)->call, re-use from
        if ($node->var instanceof \PhpParser\Node\Expr\New_) {
            $this->refactorNew($node, $node->var);
            return null;
        }
        $assignAndRootExprAndNodesToAdd = $this->createStandaloneNodesToAddFromChainMethodCalls($node, \Rector\Defluent\ValueObject\FluentCallsKind::IN_ARGS);
        if ($assignAndRootExprAndNodesToAdd === null) {
            return null;
        }
        $this->addNodesBeforeNode($assignAndRootExprAndNodesToAdd->getNodesToAdd(), $node);
        return $assignAndRootExprAndNodesToAdd->getRootCallerExpr();
    }
    private function refactorNew(\PhpParser\Node\Expr\MethodCall $methodCall, \PhpParser\Node\Expr\New_ $new) : void
    {
        if (!$this->newFluentChainMethodCallNodeAnalyzer->isNewMethodCallReturningSelf($methodCall)) {
            return;
        }
        $nodesToAdd = $this->nonFluentChainMethodCallFactory->createFromNewAndRootMethodCall($new, $methodCall);
        $newVariable = $this->crateVariableFromNew($new);
        $nodesToAdd[] = $this->createFluentAsArg($methodCall, $newVariable);
        $this->addNodesBeforeNode($nodesToAdd, $methodCall);
        $this->removeParentParent($methodCall);
    }
    private function crateVariableFromNew(\PhpParser\Node\Expr\New_ $new) : \PhpParser\Node\Expr\Variable
    {
        $variableName = $this->variableNaming->resolveFromNode($new);
        if ($variableName === null) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        return new \PhpParser\Node\Expr\Variable($variableName);
    }
    /**
     * @deprecated
     * @todo extact to factory
     */
    private function createFluentAsArg(\PhpParser\Node\Expr\MethodCall $methodCall, \PhpParser\Node\Expr\Variable $variable) : \PhpParser\Node\Expr\MethodCall
    {
        /** @var Arg $parent */
        $parent = $methodCall->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        /** @var MethodCall $parentParent */
        $parentParent = $parent->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        $lastMethodCall = new \PhpParser\Node\Expr\MethodCall($parentParent->var, $parentParent->name);
        $lastMethodCall->args[] = new \PhpParser\Node\Arg($variable);
        return $lastMethodCall;
    }
    private function removeParentParent(\PhpParser\Node\Expr\MethodCall $methodCall) : void
    {
        /** @var Arg $parent */
        $parent = $methodCall->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        /** @var MethodCall $parentParent */
        $parentParent = $parent->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        $this->removeNode($parentParent);
    }
}
