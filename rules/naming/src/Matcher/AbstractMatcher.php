<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Naming\Matcher;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Closure;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\FunctionLike;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Foreach_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Function_;
use _PhpScoper0a2ac50786fa\Rector\Naming\Contract\Matcher\MatcherInterface;
use _PhpScoper0a2ac50786fa\Rector\Naming\ValueObject\VariableAndCallAssign;
use _PhpScoper0a2ac50786fa\Rector\Naming\ValueObject\VariableAndCallForeach;
use _PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
abstract class AbstractMatcher implements \_PhpScoper0a2ac50786fa\Rector\Naming\Contract\Matcher\MatcherInterface
{
    /**
     * @var NodeNameResolver
     */
    protected $nodeNameResolver;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @param Assign|Foreach_ $node
     * @return VariableAndCallAssign|VariableAndCallForeach|null
     */
    public function match(\_PhpScoper0a2ac50786fa\PhpParser\Node $node)
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
        if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Foreach_) {
            return new \_PhpScoper0a2ac50786fa\Rector\Naming\ValueObject\VariableAndCallForeach($variable, $call, $variableName, $functionLike);
        }
        return new \_PhpScoper0a2ac50786fa\Rector\Naming\ValueObject\VariableAndCallAssign($variable, $call, $node, $variableName, $functionLike);
    }
    /**
     * @param Assign|Foreach_ $node
     * @return FuncCall|StaticCall|MethodCall|null
     */
    protected function matchCall(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if ($node->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall) {
            return $node->expr;
        }
        if ($node->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall) {
            return $node->expr;
        }
        if ($node->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall) {
            return $node->expr;
        }
        return null;
    }
    /**
     * @return ClassMethod|Function_|Closure|null
     */
    protected function getFunctionLike(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\FunctionLike
    {
        return $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLOSURE_NODE) ?? $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE) ?? $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::FUNCTION_NODE);
    }
}
