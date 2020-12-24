<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Naming\Matcher;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Closure;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\PhpParser\Node\FunctionLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Foreach_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_;
use _PhpScopere8e811afab72\Rector\Naming\Contract\Matcher\MatcherInterface;
use _PhpScopere8e811afab72\Rector\Naming\ValueObject\VariableAndCallAssign;
use _PhpScopere8e811afab72\Rector\Naming\ValueObject\VariableAndCallForeach;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
abstract class AbstractMatcher implements \_PhpScopere8e811afab72\Rector\Naming\Contract\Matcher\MatcherInterface
{
    /**
     * @var NodeNameResolver
     */
    protected $nodeNameResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @param Assign|Foreach_ $node
     * @return VariableAndCallAssign|VariableAndCallForeach|null
     */
    public function match(\_PhpScopere8e811afab72\PhpParser\Node $node)
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
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Foreach_) {
            return new \_PhpScopere8e811afab72\Rector\Naming\ValueObject\VariableAndCallForeach($variable, $call, $variableName, $functionLike);
        }
        return new \_PhpScopere8e811afab72\Rector\Naming\ValueObject\VariableAndCallAssign($variable, $call, $node, $variableName, $functionLike);
    }
    /**
     * @param Assign|Foreach_ $node
     * @return FuncCall|StaticCall|MethodCall|null
     */
    protected function matchCall(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($node->expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall) {
            return $node->expr;
        }
        if ($node->expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall) {
            return $node->expr;
        }
        if ($node->expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall) {
            return $node->expr;
        }
        return null;
    }
    /**
     * @return ClassMethod|Function_|Closure|null
     */
    protected function getFunctionLike(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node\FunctionLike
    {
        return $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLOSURE_NODE) ?? $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE) ?? $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::FUNCTION_NODE);
    }
}
