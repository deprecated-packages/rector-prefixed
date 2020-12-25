<?php

declare (strict_types=1);
namespace Rector\Naming\Matcher;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\FunctionLike;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Foreach_;
use PhpParser\Node\Stmt\Function_;
use Rector\Naming\Contract\Matcher\MatcherInterface;
use Rector\Naming\ValueObject\VariableAndCallAssign;
use Rector\Naming\ValueObject\VariableAndCallForeach;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
abstract class AbstractMatcher implements \Rector\Naming\Contract\Matcher\MatcherInterface
{
    /**
     * @var NodeNameResolver
     */
    protected $nodeNameResolver;
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @param Assign|Foreach_ $node
     * @return VariableAndCallAssign|VariableAndCallForeach|null
     */
    public function match(\PhpParser\Node $node)
    {
        $call = $this->matchCall($node);
        if ($call === null) {
            return null;
        }
        $variableName = $this->getVariableName($node);
        if ($variableName === null) {
            return null;
        }
        $functionLike = $this->getFunctionLike($node);
        if ($functionLike === null) {
            return null;
        }
        $variable = $this->getVariable($node);
        if ($node instanceof \PhpParser\Node\Stmt\Foreach_) {
            return new \Rector\Naming\ValueObject\VariableAndCallForeach($variable, $call, $variableName, $functionLike);
        }
        return new \Rector\Naming\ValueObject\VariableAndCallAssign($variable, $call, $node, $variableName, $functionLike);
    }
    /**
     * @param Assign|Foreach_ $node
     * @return FuncCall|StaticCall|MethodCall|null
     */
    protected function matchCall(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($node->expr instanceof \PhpParser\Node\Expr\MethodCall) {
            return $node->expr;
        }
        if ($node->expr instanceof \PhpParser\Node\Expr\StaticCall) {
            return $node->expr;
        }
        if ($node->expr instanceof \PhpParser\Node\Expr\FuncCall) {
            return $node->expr;
        }
        return null;
    }
    /**
     * @return ClassMethod|Function_|Closure|null
     */
    protected function getFunctionLike(\PhpParser\Node $node) : ?\PhpParser\Node\FunctionLike
    {
        return $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLOSURE_NODE) ?? $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE) ?? $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::FUNCTION_NODE);
    }
}
