<?php

declare(strict_types=1);

namespace Rector\Naming\Matcher;

use PhpParser\Node;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Foreach_;
use PhpParser\Node\Stmt\Function_;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use Rector\Naming\ValueObject\VariableAndCallForeach;
use Rector\NodeNameResolver\NodeNameResolver;

final class ForeachMatcher
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;

    /**
     * @var CallMatcher
     */
    private $callMatcher;

    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;

    public function __construct(
        NodeNameResolver $nodeNameResolver,
        CallMatcher $callMatcher,
        BetterNodeFinder $betterNodeFinder
    ) {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->callMatcher = $callMatcher;
        $this->betterNodeFinder = $betterNodeFinder;
    }

    /**
     * @return \Rector\Naming\ValueObject\VariableAndCallForeach|null
     */
    public function match(Foreach_ $foreach)
    {
        $call = $this->callMatcher->matchCall($foreach);
        if ($call === null) {
            return null;
        }

        if (! $foreach->valueVar instanceof Variable) {
            return null;
        }

        $functionLike = $this->getFunctionLike($foreach);
        if ($functionLike === null) {
            return null;
        }

        $variableName = $this->nodeNameResolver->getName($foreach->valueVar);
        if ($variableName === null) {
            return null;
        }

        return new VariableAndCallForeach($foreach->valueVar, $call, $variableName, $functionLike);
    }

    /**
     * @return \PhpParser\Node|null
     */
    private function getFunctionLike(Foreach_ $foreach)
    {
        return $this->betterNodeFinder->findParentTypes(
            $foreach,
            [Closure::class, ClassMethod::class, Function_::class]
        );
    }
}
