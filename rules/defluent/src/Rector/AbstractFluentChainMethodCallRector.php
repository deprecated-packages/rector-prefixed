<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Defluent\Rector;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Arg;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\New_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\Defluent\NodeAnalyzer\FluentChainMethodCallNodeAnalyzer;
use _PhpScoper0a2ac50786fa\Rector\Defluent\NodeAnalyzer\FluentChainMethodCallRootExtractor;
use _PhpScoper0a2ac50786fa\Rector\Defluent\NodeAnalyzer\SameClassMethodCallAnalyzer;
use _PhpScoper0a2ac50786fa\Rector\Defluent\NodeFactory\NonFluentChainMethodCallFactory;
use _PhpScoper0a2ac50786fa\Rector\Defluent\Skipper\FluentMethodCallSkipper;
use _PhpScoper0a2ac50786fa\Rector\Defluent\ValueObject\AssignAndRootExprAndNodesToAdd;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
abstract class AbstractFluentChainMethodCallRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
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
    public function autowireAbstractFluentChainMethodCallRector(\_PhpScoper0a2ac50786fa\Rector\Defluent\NodeAnalyzer\FluentChainMethodCallNodeAnalyzer $fluentChainMethodCallNodeAnalyzer, \_PhpScoper0a2ac50786fa\Rector\Defluent\NodeAnalyzer\FluentChainMethodCallRootExtractor $fluentChainMethodCallRootExtractor, \_PhpScoper0a2ac50786fa\Rector\Defluent\NodeFactory\NonFluentChainMethodCallFactory $nonFluentChainMethodCallFactory, \_PhpScoper0a2ac50786fa\Rector\Defluent\NodeAnalyzer\SameClassMethodCallAnalyzer $sameClassMethodCallAnalyzer, \_PhpScoper0a2ac50786fa\Rector\Defluent\Skipper\FluentMethodCallSkipper $fluentMethodCallSkipper) : void
    {
        $this->fluentChainMethodCallNodeAnalyzer = $fluentChainMethodCallNodeAnalyzer;
        $this->fluentChainMethodCallRootExtractor = $fluentChainMethodCallRootExtractor;
        $this->nonFluentChainMethodCallFactory = $nonFluentChainMethodCallFactory;
        $this->sameClassMethodCallAnalyzer = $sameClassMethodCallAnalyzer;
        $this->fluentMethodCallSkipper = $fluentMethodCallSkipper;
    }
    protected function createStandaloneNodesToAddFromChainMethodCalls(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $methodCall, string $kind) : ?\_PhpScoper0a2ac50786fa\Rector\Defluent\ValueObject\AssignAndRootExprAndNodesToAdd
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
        return new \_PhpScoper0a2ac50786fa\Rector\Defluent\ValueObject\AssignAndRootExprAndNodesToAdd($assignAndRootExpr, $nodesToAdd);
    }
    /**
     * @param MethodCall|Return_ $node
     */
    protected function removeCurrentNode(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : void
    {
        $parent = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parent instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign) {
            $this->removeNode($parent);
            return;
        }
        // part of method call
        if ($parent instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg) {
            $parentParent = $parent->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($parentParent instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall) {
                $this->removeNode($parentParent);
            }
            return;
        }
        $this->removeNode($node);
    }
    protected function shouldSkipMethodCall(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        return $this->fluentMethodCallSkipper->shouldSkipRootMethodCall($methodCall);
    }
    protected function matchReturnMethodCall(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_ $return) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall
    {
        if ($return->expr === null) {
            return null;
        }
        if (!$return->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall) {
            return null;
        }
        return $return->expr;
    }
    protected function shouldSkipMethodCallIncludingNew(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        if ($this->shouldSkipMethodCall($methodCall)) {
            return \true;
        }
        $chainRootExpr = $this->fluentChainMethodCallNodeAnalyzer->resolveRootExpr($methodCall);
        return $chainRootExpr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\New_;
    }
}
