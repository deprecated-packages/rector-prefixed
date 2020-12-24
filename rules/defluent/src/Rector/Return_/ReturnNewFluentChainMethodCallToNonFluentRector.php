<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Defluent\Rector\Return_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_;
use _PhpScopere8e811afab72\Rector\Defluent\Rector\AbstractFluentChainMethodCallRector;
use _PhpScopere8e811afab72\Rector\Defluent\ValueObject\FluentCallsKind;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://ocramius.github.io/blog/fluent-interfaces-are-evil/
 * @see https://www.yegor256.com/2018/03/13/fluent-interfaces.html
 *
 * @see \Rector\Defluent\Tests\Rector\MethodCall\FluentChainMethodCallToNormalMethodCallRector\FluentChainMethodCallToNormalMethodCallRectorTest
 * @see \Rector\Defluent\Tests\Rector\Return_\ReturnNewFluentChainMethodCallToNonFluentRector\ReturnNewFluentChainMethodCallToNonFluentRectorTest
 */
final class ReturnNewFluentChainMethodCallToNonFluentRector extends \_PhpScopere8e811afab72\Rector\Defluent\Rector\AbstractFluentChainMethodCallRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns fluent interface calls to classic ones.', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
return (new SomeClass())->someFunction()
            ->otherFunction();
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$someClass = new SomeClass();
$someClass->someFunction();
$someClass->otherFunction();
return $someClass;
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_::class];
    }
    /**
     * @param Return_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $methodCall = $this->matchReturnMethodCall($node);
        if ($methodCall === null) {
            return null;
        }
        if ($this->shouldSkipMethodCall($methodCall)) {
            return null;
        }
        $assignAndRootExprAndNodesToAdd = $this->createStandaloneNodesToAddFromChainMethodCalls($methodCall, \_PhpScopere8e811afab72\Rector\Defluent\ValueObject\FluentCallsKind::NORMAL);
        if ($assignAndRootExprAndNodesToAdd === null) {
            return null;
        }
        $this->removeCurrentNode($node);
        $this->addNodesAfterNode($assignAndRootExprAndNodesToAdd->getNodesToAdd(), $node);
        return null;
    }
}
