<?php

declare (strict_types=1);
namespace Rector\Core\PhpParser\Node\Value;

use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Expression;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
final class ClassResolver
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function getClassFromMethodCall(\PhpParser\Node\Expr\MethodCall $methodCall) : ?\PhpParser\Node\Name\FullyQualified
    {
        $previousExpression = $methodCall->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_STATEMENT);
        // [PhpParser\Node\Expr\Assign] $variable = new Class()
        if ($previousExpression instanceof \PhpParser\Node\Stmt\Expression) {
            return $this->resolveFromExpression($previousExpression);
        }
        if ($previousExpression instanceof \PhpParser\Node\Stmt\ClassMethod) {
            return $this->resolveFromClassMethod($previousExpression, $methodCall);
        }
        return null;
    }
    private function resolveFromExpression(\PhpParser\Node\Stmt\Expression $expression) : ?\PhpParser\Node\Name\FullyQualified
    {
        $assign = $expression->expr;
        if (!$assign instanceof \PhpParser\Node\Expr\Assign) {
            return null;
        }
        $new = $assign->expr;
        if (!$new instanceof \PhpParser\Node\Expr\New_) {
            return null;
        }
        $class = $new->class;
        return $class instanceof \PhpParser\Node\Name\FullyQualified ? $class : null;
    }
    private function resolveFromClassMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod, \PhpParser\Node\Expr\MethodCall $methodCall) : ?\PhpParser\Node\Name\FullyQualified
    {
        $var = $methodCall->var;
        if (!$var instanceof \PhpParser\Node\Expr\Variable) {
            return null;
        }
        return $this->nodeNameResolver->isName($var, 'this') ? $this->tryToResolveClassMethodFromThis($classMethod) : $this->tryToResolveClassMethodParams($classMethod, $methodCall);
    }
    private function tryToResolveClassMethodFromThis(\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\PhpParser\Node\Name\FullyQualified
    {
        $class = $classMethod->name->getAttribute(\PhpParser\Node\Stmt\ClassLike::class)->name;
        if (!$class instanceof \PhpParser\Node\Identifier) {
            return null;
        }
        /** @var string $className */
        $className = $class->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        return new \PhpParser\Node\Name\FullyQualified($className);
    }
    private function tryToResolveClassMethodParams(\PhpParser\Node\Stmt\ClassMethod $classMethod, \PhpParser\Node\Expr\MethodCall $methodCall) : ?\PhpParser\Node\Name\FullyQualified
    {
        // $ param -> method();
        $params = $classMethod->params;
        /** @var Param $param */
        foreach ($params as $param) {
            $paramVar = $param->var;
            $methodCallVar = $methodCall->var;
            if (!$paramVar instanceof \PhpParser\Node\Expr\Variable) {
                continue;
            }
            if (!$methodCallVar instanceof \PhpParser\Node\Expr\Variable) {
                continue;
            }
            if ($paramVar->name === $methodCallVar->name) {
                $class = $param->type;
                return $class instanceof \PhpParser\Node\Name\FullyQualified ? $class : null;
            }
        }
        return null;
    }
}
