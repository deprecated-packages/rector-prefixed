<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Defluent\Rector;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Defluent\NodeAnalyzer\FluentChainMethodCallNodeAnalyzer;
use _PhpScoperb75b35f52b74\Rector\Defluent\NodeAnalyzer\FluentChainMethodCallRootExtractor;
use _PhpScoperb75b35f52b74\Rector\Defluent\NodeAnalyzer\SameClassMethodCallAnalyzer;
use _PhpScoperb75b35f52b74\Rector\Defluent\NodeFactory\NonFluentChainMethodCallFactory;
use _PhpScoperb75b35f52b74\Rector\Defluent\Skipper\FluentMethodCallSkipper;
use _PhpScoperb75b35f52b74\Rector\Defluent\ValueObject\AssignAndRootExprAndNodesToAdd;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
abstract class AbstractFluentChainMethodCallRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var FluentChainMethodCallNodeAnalyzer
     */
    protected $fluentChainMethodCallNodeAnalyzer;
    /**
     * @var NonFluentChainMethodCallFactory
     */
    protected $nonFluentChainMethodCallFactory;
    /**
     * @var FluentChainMethodCallRootExtractor
     */
    protected $fluentChainMethodCallRootExtractor;
    /**
     * @var SameClassMethodCallAnalyzer
     */
    protected $sameClassMethodCallAnalyzer;
    /**
     * @var FluentMethodCallSkipper
     */
    protected $fluentMethodCallSkipper;
    /**
     * @required
     */
    public function autowireAbstractFluentChainMethodCallRector(\_PhpScoperb75b35f52b74\Rector\Defluent\NodeAnalyzer\FluentChainMethodCallNodeAnalyzer $fluentChainMethodCallNodeAnalyzer, \_PhpScoperb75b35f52b74\Rector\Defluent\NodeAnalyzer\FluentChainMethodCallRootExtractor $fluentChainMethodCallRootExtractor, \_PhpScoperb75b35f52b74\Rector\Defluent\NodeFactory\NonFluentChainMethodCallFactory $nonFluentChainMethodCallFactory, \_PhpScoperb75b35f52b74\Rector\Defluent\NodeAnalyzer\SameClassMethodCallAnalyzer $sameClassMethodCallAnalyzer, \_PhpScoperb75b35f52b74\Rector\Defluent\Skipper\FluentMethodCallSkipper $fluentMethodCallSkipper) : void
    {
        $this->fluentChainMethodCallNodeAnalyzer = $fluentChainMethodCallNodeAnalyzer;
        $this->fluentChainMethodCallRootExtractor = $fluentChainMethodCallRootExtractor;
        $this->nonFluentChainMethodCallFactory = $nonFluentChainMethodCallFactory;
        $this->sameClassMethodCallAnalyzer = $sameClassMethodCallAnalyzer;
        $this->fluentMethodCallSkipper = $fluentMethodCallSkipper;
    }
    protected function createStandaloneNodesToAddFromChainMethodCalls(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall, string $kind) : ?\_PhpScoperb75b35f52b74\Rector\Defluent\ValueObject\AssignAndRootExprAndNodesToAdd
    {
        $chainMethodCalls = $this->fluentChainMethodCallNodeAnalyzer->collectAllMethodCallsInChain($methodCall);
        if (!$this->sameClassMethodCallAnalyzer->haveSingleClass($chainMethodCalls)) {
            return null;
        }
        $assignAndRootExpr = $this->fluentChainMethodCallRootExtractor->extractFromMethodCalls($chainMethodCalls, $kind);
        if ($assignAndRootExpr === null) {
            return null;
        }
        if ($this->fluentMethodCallSkipper->shouldSkipMethodCalls($assignAndRootExpr, $chainMethodCalls)) {
            return null;
        }
        $nodesToAdd = $this->nonFluentChainMethodCallFactory->createFromAssignObjectAndMethodCalls($assignAndRootExpr, $chainMethodCalls, $kind);
        return new \_PhpScoperb75b35f52b74\Rector\Defluent\ValueObject\AssignAndRootExprAndNodesToAdd($assignAndRootExpr, $nodesToAdd);
    }
    /**
     * @param MethodCall|Return_ $node
     */
    protected function removeCurrentNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : void
    {
        $parent = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parent instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
            $this->removeNode($parent);
            return;
        }
        // part of method call
        if ($parent instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Arg) {
            $parentParent = $parent->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($parentParent instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall) {
                $this->removeNode($parentParent);
            }
            return;
        }
        $this->removeNode($node);
    }
    protected function shouldSkipMethodCall(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        return $this->fluentMethodCallSkipper->shouldSkipRootMethodCall($methodCall);
    }
    protected function matchReturnMethodCall(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_ $return) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall
    {
        if ($return->expr === null) {
            return null;
        }
        if (!$return->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall) {
            return null;
        }
        return $return->expr;
    }
    protected function shouldSkipMethodCallIncludingNew(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        if ($this->shouldSkipMethodCall($methodCall)) {
            return \true;
        }
        $chainRootExpr = $this->fluentChainMethodCallNodeAnalyzer->resolveRootExpr($methodCall);
        return $chainRootExpr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_;
    }
}
