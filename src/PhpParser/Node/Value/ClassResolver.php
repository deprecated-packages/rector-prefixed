<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Value;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
final class ClassResolver
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function getClassFromMethodCall(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified
    {
        $class = null;
        $previousExpression = $methodCall->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_STATEMENT);
        // [PhpParser\Node\Expr\Assign] $variable = new Class()
        if ($previousExpression instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression) {
            $class = $this->resolveFromExpression($previousExpression);
        }
        if ($previousExpression instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod) {
            $class = $this->resolveFromClassMethod($previousExpression, $methodCall);
        }
        return $class;
    }
    private function resolveFromExpression(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression $expression) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified
    {
        $assign = $expression->expr;
        if (!$assign instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
            return null;
        }
        $new = $assign->expr;
        if (!$new instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_) {
            return null;
        }
        $class = $new->class;
        return $class instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified ? $class : null;
    }
    private function resolveFromClassMethod(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified
    {
        $var = $methodCall->var;
        if (!$var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable) {
            return null;
        }
        return $this->nodeNameResolver->isName($var, 'this') ? $this->tryToResolveClassMethodFromThis($classMethod) : $this->tryToResolveClassMethodParams($classMethod, $methodCall);
    }
    private function tryToResolveClassMethodFromThis(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified
    {
        $class = $classMethod->name->getAttribute(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike::class)->name;
        if (!$class instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier) {
            return null;
        }
        /** @var string $className */
        $className = $class->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified($className);
    }
    private function tryToResolveClassMethodParams(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified
    {
        // $ param -> method();
        $params = $classMethod->params;
        /** @var Param $param */
        foreach ($params as $param) {
            $paramVar = $param->var;
            $methodCallVar = $methodCall->var;
            if (!$paramVar instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable || !$methodCallVar instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable) {
                continue;
            }
            if ($paramVar->name === $methodCallVar->name) {
                $class = $param->type;
                return $class instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified ? $class : null;
            }
        }
        return null;
    }
}
