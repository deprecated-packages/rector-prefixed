<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Defluent\Rector\Return_;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\New_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_;
use _PhpScoper0a2ac50786fa\Rector\Defluent\NodeFactory\ReturnFluentMethodCallFactory;
use _PhpScoper0a2ac50786fa\Rector\Defluent\NodeFactory\SeparateReturnMethodCallFactory;
use _PhpScoper0a2ac50786fa\Rector\Defluent\Rector\AbstractFluentChainMethodCallRector;
use _PhpScoper0a2ac50786fa\Rector\Defluent\ValueObjectFactory\FluentMethodCallsFactory;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://ocramius.github.io/blog/fluent-interfaces-are-evil/
 * @see https://www.yegor256.com/2018/03/13/fluent-interfaces.html
 *
 * @see \Rector\Defluent\Tests\Rector\Return_\ReturnFluentChainMethodCallToNormalMethodCallRector\ReturnFluentChainMethodCallToNormalMethodCallRectorTest
 */
final class ReturnFluentChainMethodCallToNormalMethodCallRector extends \_PhpScoper0a2ac50786fa\Rector\Defluent\Rector\AbstractFluentChainMethodCallRector
{
    /**
     * @var ReturnFluentMethodCallFactory
     */
    private $returnFluentMethodCallFactory;
    /**
     * @var FluentMethodCallsFactory
     */
    private $fluentMethodCallsFactory;
    /**
     * @var SeparateReturnMethodCallFactory
     */
    private $separateReturnMethodCallFactory;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Defluent\NodeFactory\ReturnFluentMethodCallFactory $returnFluentMethodCallFactory, \_PhpScoper0a2ac50786fa\Rector\Defluent\ValueObjectFactory\FluentMethodCallsFactory $fluentMethodCallsFactory, \_PhpScoper0a2ac50786fa\Rector\Defluent\NodeFactory\SeparateReturnMethodCallFactory $separateReturnMethodCallFactory)
    {
        $this->returnFluentMethodCallFactory = $returnFluentMethodCallFactory;
        $this->fluentMethodCallsFactory = $fluentMethodCallsFactory;
        $this->separateReturnMethodCallFactory = $separateReturnMethodCallFactory;
    }
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns fluent interface calls to classic ones.', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
$someClass = new SomeClass();
return $someClass->someFunction()
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_::class];
    }
    /**
     * @param Return_ $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        $methodCall = $this->matchReturnMethodCall($node);
        if ($methodCall === null) {
            return null;
        }
        if ($this->shouldSkipMethodCallIncludingNew($methodCall)) {
            return null;
        }
        $nodesToAdd = $this->createStandaloneNodesToAddFromReturnFluentMethodCalls($methodCall);
        if ($nodesToAdd === []) {
            return null;
        }
        $this->removeCurrentNode($node);
        $this->addNodesAfterNode($nodesToAdd, $node);
        return null;
    }
    protected function shouldSkipMethodCallIncludingNew(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        if ($this->shouldSkipMethodCall($methodCall)) {
            return \true;
        }
        $rootVariable = $this->fluentChainMethodCallNodeAnalyzer->resolveRootExpr($methodCall);
        return $rootVariable instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\New_;
    }
    /**
     * @return Node[]
     */
    private function createStandaloneNodesToAddFromReturnFluentMethodCalls(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $methodCall) : array
    {
        $fluentMethodCalls = $this->fluentMethodCallsFactory->createFromLastMethodCall($methodCall);
        if ($fluentMethodCalls === null) {
            return [];
        }
        $firstAssignFluentCall = $this->returnFluentMethodCallFactory->createFromFluentMethodCalls($fluentMethodCalls);
        if ($firstAssignFluentCall === null) {
            return [];
        }
        // should be skipped?
        if ($this->fluentMethodCallSkipper->shouldSkipFirstAssignFluentCall($firstAssignFluentCall)) {
            return [];
        }
        return $this->separateReturnMethodCallFactory->createReturnFromFirstAssignFluentCallAndFluentMethodCalls($firstAssignFluentCall, $fluentMethodCalls);
    }
}
