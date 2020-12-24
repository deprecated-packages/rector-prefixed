<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\Value;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\New_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Identifier;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
final class ClassResolver
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function getClassFromMethodCall(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall $methodCall) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified
    {
        $class = null;
        $previousExpression = $methodCall->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_STATEMENT);
        // [PhpParser\Node\Expr\Assign] $variable = new Class()
        if ($previousExpression instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression) {
            $class = $this->resolveFromExpression($previousExpression);
        }
        if ($previousExpression instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod) {
            $class = $this->resolveFromClassMethod($previousExpression, $methodCall);
        }
        return $class;
    }
    private function resolveFromExpression(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression $expression) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified
    {
        $assign = $expression->expr;
        if (!$assign instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign) {
            return null;
        }
        $new = $assign->expr;
        if (!$new instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\New_) {
            return null;
        }
        $class = $new->class;
        return $class instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified ? $class : null;
    }
    private function resolveFromClassMethod(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall $methodCall) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified
    {
        $var = $methodCall->var;
        if (!$var instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable) {
            return null;
        }
        return $this->nodeNameResolver->isName($var, 'this') ? $this->tryToResolveClassMethodFromThis($classMethod) : $this->tryToResolveClassMethodParams($classMethod, $methodCall);
    }
    private function tryToResolveClassMethodFromThis(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified
    {
        $class = $classMethod->name->getAttribute(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassLike::class)->name;
        if (!$class instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Identifier) {
            return null;
        }
        /** @var string $className */
        $className = $class->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified($className);
    }
    private function tryToResolveClassMethodParams(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall $methodCall) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified
    {
        // $ param -> method();
        $params = $classMethod->params;
        /** @var Param $param */
        foreach ($params as $param) {
            $paramVar = $param->var;
            $methodCallVar = $methodCall->var;
            if (!$paramVar instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable || !$methodCallVar instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable) {
                continue;
            }
            if ($paramVar->name === $methodCallVar->name) {
                $class = $param->type;
                return $class instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified ? $class : null;
            }
        }
        return null;
    }
}
