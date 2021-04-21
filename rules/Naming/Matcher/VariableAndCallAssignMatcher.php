<?php

declare(strict_types=1);

namespace Rector\Naming\Matcher;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\FunctionLike;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Function_;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use Rector\Naming\ValueObject\VariableAndCallAssign;
use Rector\NodeNameResolver\NodeNameResolver;

final class VariableAndCallAssignMatcher
{
    /**
     * @var CallMatcher
     */
    private $callMatcher;

    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;

    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;

    public function __construct(
        CallMatcher $callMatcher,
        NodeNameResolver $nodeNameResolver,
        BetterNodeFinder $betterNodeFinder
    ) {
        $this->callMatcher = $callMatcher;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->betterNodeFinder = $betterNodeFinder;
    }

    /**
     * @return \Rector\Naming\ValueObject\VariableAndCallAssign|null
     */
    public function match(Assign $assign)
    {
        $call = $this->callMatcher->matchCall($assign);
        if ($call === null) {
            return null;
        }

        if (! $assign->var instanceof Variable) {
            return null;
        }

        $variableName = $this->nodeNameResolver->getName($assign->var);
        if ($variableName === null) {
            return null;
        }

        $functionLike = $this->getFunctionLike($assign);
        if (! $functionLike instanceof FunctionLike) {
            return null;
        }

        return new VariableAndCallAssign($assign->var, $call, $assign, $variableName, $functionLike);
    }

    /**
     * @return \PhpParser\Node|null
     */
    private function getFunctionLike(Assign $assign)
    {
        return $this->betterNodeFinder->findParentTypes(
            $assign,
            [Closure::class, ClassMethod::class, Function_::class]
        );
    }
}
