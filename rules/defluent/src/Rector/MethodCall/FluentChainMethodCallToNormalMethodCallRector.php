<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Defluent\Rector\MethodCall;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_;
use _PhpScoperb75b35f52b74\Rector\Defluent\Rector\AbstractFluentChainMethodCallRector;
use _PhpScoperb75b35f52b74\Rector\Defluent\Rector\Return_\DefluentReturnMethodCallRector;
use _PhpScoperb75b35f52b74\Rector\Defluent\ValueObject\FluentCallsKind;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://ocramius.github.io/blog/fluent-interfaces-are-evil/
 * @see https://www.yegor256.com/2018/03/13/fluent-interfaces.html
 *
 * @see \Rector\Defluent\Tests\Rector\MethodCall\FluentChainMethodCallToNormalMethodCallRector\FluentChainMethodCallToNormalMethodCallRectorTest
 */
final class FluentChainMethodCallToNormalMethodCallRector extends \_PhpScoperb75b35f52b74\Rector\Defluent\Rector\AbstractFluentChainMethodCallRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns fluent interface calls to classic ones.', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
$someClass = new SomeClass();
$someClass->someFunction()
            ->otherFunction();
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$someClass = new SomeClass();
$someClass->someFunction();
$someClass->otherFunction();
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
        if ($this->isHandledByAnotherRule($node)) {
            return null;
        }
        if ($this->shouldSkipMethodCallIncludingNew($node)) {
            return null;
        }
        $assignAndRootExprAndNodesToAdd = $this->createStandaloneNodesToAddFromChainMethodCalls($node, \_PhpScoperb75b35f52b74\Rector\Defluent\ValueObject\FluentCallsKind::NORMAL);
        if ($assignAndRootExprAndNodesToAdd === null) {
            return null;
        }
        $this->removeCurrentNode($node);
        $this->addNodesAfterNode($assignAndRootExprAndNodesToAdd->getNodesToAdd(), $node);
        return null;
    }
    /**
     * Is handled by:
     * @see DefluentReturnMethodCallRector
     * @see InArgFluentChainMethodCallToStandaloneMethodCallRector
     */
    private function isHandledByAnotherRule(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        return $this->hasParentTypes($methodCall, [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Arg::class]);
    }
}
