<?php

declare (strict_types=1);
namespace Rector\Defluent\Rector\Return_;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Stmt\Return_;
use Rector\Defluent\NodeFactory\ReturnFluentMethodCallFactory;
use Rector\Defluent\NodeFactory\SeparateReturnMethodCallFactory;
use Rector\Defluent\Rector\AbstractFluentChainMethodCallRector;
use Rector\Defluent\ValueObject\FirstAssignFluentCall;
use Rector\Defluent\ValueObject\FluentMethodCalls;
use Rector\Defluent\ValueObjectFactory\FluentMethodCallsFactory;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://ocramius.github.io/blog/fluent-interfaces-are-evil/
 * @see https://www.yegor256.com/2018/03/13/fluent-interfaces.html
 *
 * @see \Rector\Defluent\Tests\Rector\Return_\ReturnFluentChainMethodCallToNormalMethodCallRector\ReturnFluentChainMethodCallToNormalMethodCallRectorTest
 */
final class ReturnFluentChainMethodCallToNormalMethodCallRector extends \Rector\Defluent\Rector\AbstractFluentChainMethodCallRector
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
    public function __construct(\Rector\Defluent\NodeFactory\ReturnFluentMethodCallFactory $returnFluentMethodCallFactory, \Rector\Defluent\ValueObjectFactory\FluentMethodCallsFactory $fluentMethodCallsFactory, \Rector\Defluent\NodeFactory\SeparateReturnMethodCallFactory $separateReturnMethodCallFactory)
    {
        $this->returnFluentMethodCallFactory = $returnFluentMethodCallFactory;
        $this->fluentMethodCallsFactory = $fluentMethodCallsFactory;
        $this->separateReturnMethodCallFactory = $separateReturnMethodCallFactory;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns fluent interface calls to classic ones.', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\PhpParser\Node\Stmt\Return_::class];
    }
    /**
     * @param Return_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        $methodCall = $this->matchReturnMethodCall($node);
        if (!$methodCall instanceof \PhpParser\Node\Expr\MethodCall) {
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
    /**
     * @return Node[]
     */
    private function createStandaloneNodesToAddFromReturnFluentMethodCalls(\PhpParser\Node\Expr\MethodCall $methodCall) : array
    {
        $fluentMethodCalls = $this->fluentMethodCallsFactory->createFromLastMethodCall($methodCall);
        if (!$fluentMethodCalls instanceof \Rector\Defluent\ValueObject\FluentMethodCalls) {
            return [];
        }
        $firstAssignFluentCall = $this->returnFluentMethodCallFactory->createFromFluentMethodCalls($fluentMethodCalls);
        if (!$firstAssignFluentCall instanceof \Rector\Defluent\ValueObject\FirstAssignFluentCall) {
            return [];
        }
        // should be skipped?
        if ($this->fluentMethodCallSkipper->shouldSkipFirstAssignFluentCall($firstAssignFluentCall)) {
            return [];
        }
        return $this->separateReturnMethodCallFactory->createReturnFromFirstAssignFluentCallAndFluentMethodCalls($firstAssignFluentCall, $fluentMethodCalls);
    }
}
