<?php

declare (strict_types=1);
namespace Rector\Defluent\Rector\Return_;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Stmt\Return_;
use Rector\Core\Rector\AbstractRector;
use Rector\Defluent\Matcher\AssignAndRootExprAndNodesToAddMatcher;
use Rector\Defluent\Skipper\FluentMethodCallSkipper;
use Rector\Defluent\ValueObject\AssignAndRootExprAndNodesToAdd;
use Rector\Defluent\ValueObject\FluentCallsKind;
use Rector\Symfony\NodeAnalyzer\FluentNodeRemover;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @changelog https://ocramius.github.io/blog/fluent-interfaces-are-evil/
 *
 * @see \Rector\Tests\Defluent\Rector\MethodCall\FluentChainMethodCallToNormalMethodCallRector\FluentChainMethodCallToNormalMethodCallRectorTest
 * @see \Rector\Tests\Defluent\Rector\Return_\ReturnNewFluentChainMethodCallToNonFluentRector\ReturnNewFluentChainMethodCallToNonFluentRectorTest
 */
final class ReturnNewFluentChainMethodCallToNonFluentRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var FluentNodeRemover
     */
    private $fluentNodeRemover;
    /**
     * @var AssignAndRootExprAndNodesToAddMatcher
     */
    private $assignAndRootExprAndNodesToAddMatcher;
    /**
     * @var FluentMethodCallSkipper
     */
    private $fluentMethodCallSkipper;
    public function __construct(\Rector\Symfony\NodeAnalyzer\FluentNodeRemover $fluentNodeRemover, \Rector\Defluent\Matcher\AssignAndRootExprAndNodesToAddMatcher $assignAndRootExprAndNodesToAddMatcher, \Rector\Defluent\Skipper\FluentMethodCallSkipper $fluentMethodCallSkipper)
    {
        $this->fluentNodeRemover = $fluentNodeRemover;
        $this->assignAndRootExprAndNodesToAddMatcher = $assignAndRootExprAndNodesToAddMatcher;
        $this->fluentMethodCallSkipper = $fluentMethodCallSkipper;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns fluent interface calls to classic ones.', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
     * @return array<class-string<Node>>
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
        if ($this->fluentMethodCallSkipper->shouldSkipRootMethodCall($methodCall)) {
            return null;
        }
        $assignAndRootExprAndNodesToAdd = $this->assignAndRootExprAndNodesToAddMatcher->match($methodCall, \Rector\Defluent\ValueObject\FluentCallsKind::NORMAL);
        if (!$assignAndRootExprAndNodesToAdd instanceof \Rector\Defluent\ValueObject\AssignAndRootExprAndNodesToAdd) {
            return null;
        }
        $this->fluentNodeRemover->removeCurrentNode($node);
        $this->addNodesAfterNode($assignAndRootExprAndNodesToAdd->getNodesToAdd(), $node);
        return null;
    }
    private function matchReturnMethodCall(\PhpParser\Node\Stmt\Return_ $return) : ?\PhpParser\Node\Expr
    {
        if ($return->expr === null) {
            return null;
        }
        if (!$return->expr instanceof \PhpParser\Node\Expr\MethodCall) {
            return null;
        }
        return $return->expr;
    }
}
