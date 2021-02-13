<?php

declare (strict_types=1);
namespace Rector\Nette\NodeAnalyzer;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\NodeTraverser;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeNestingScope\ScopeNestingComparator;
use RectorPrefix20210213\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser;
final class RenderMethodAnalyzer
{
    /**
     * @var SimpleCallableNodeTraverser
     */
    private $simpleCallableNodeTraverser;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var ScopeNestingComparator
     */
    private $scopeNestingComparator;
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    public function __construct(\RectorPrefix20210213\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser $simpleCallableNodeTraverser, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\NodeNestingScope\ScopeNestingComparator $scopeNestingComparator, \Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder)
    {
        $this->simpleCallableNodeTraverser = $simpleCallableNodeTraverser;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->scopeNestingComparator = $scopeNestingComparator;
        $this->betterNodeFinder = $betterNodeFinder;
    }
    public function machRenderMethodCall(\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\PhpParser\Node\Expr\MethodCall
    {
        /** @var MethodCall[] $methodsCalls */
        $methodsCalls = $this->betterNodeFinder->findInstanceOf((array) $classMethod->stmts, \PhpParser\Node\Expr\MethodCall::class);
        foreach ($methodsCalls as $methodCall) {
            if ($this->nodeNameResolver->isName($methodCall->name, 'render')) {
                return $methodCall;
            }
        }
        return null;
    }
    public function hasConditionalTemplateAssigns(\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        $hasConditionalAssigns = \false;
        $this->simpleCallableNodeTraverser->traverseNodesWithCallable($classMethod, function (\PhpParser\Node $node) use(&$hasConditionalAssigns) : ?int {
            if (!$node instanceof \PhpParser\Node\Expr\Assign) {
                return null;
            }
            if (!$this->isThisTemplatePropertyFetch($node->var)) {
                return null;
            }
            if ($this->scopeNestingComparator->isNodeConditionallyScoped($node->var)) {
                $hasConditionalAssigns = \true;
                return \PhpParser\NodeTraverser::STOP_TRAVERSAL;
            }
            return null;
        });
        return $hasConditionalAssigns;
    }
    private function isThisTemplatePropertyFetch(\PhpParser\Node\Expr $expr) : bool
    {
        if (!$expr instanceof \PhpParser\Node\Expr\PropertyFetch) {
            return \false;
        }
        if (!$expr->var instanceof \PhpParser\Node\Expr\PropertyFetch) {
            return \false;
        }
        $nestedPropertyFetch = $expr->var;
        if (!$this->nodeNameResolver->isName($nestedPropertyFetch->var, 'this')) {
            return \false;
        }
        return $this->nodeNameResolver->isName($nestedPropertyFetch->name, 'template');
    }
}
