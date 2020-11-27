<?php

declare (strict_types=1);
namespace Rector\DoctrineCodeQuality\NodeAnalyzer;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Property;
use PHPStan\Type\TypeWithClassName;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\NodeTypeResolver\NodeTypeResolver;
final class SetterClassMethodAnalyzer
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function matchNullalbeClassMethodProperty(\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\PhpParser\Node\Stmt\Property
    {
        $propertyFetch = $this->matchNullalbeClassMethodPropertyFetch($classMethod);
        if ($propertyFetch === null) {
            return null;
        }
        return $this->getPropertyByPropertyFetch($classMethod, $propertyFetch);
    }
    public function matchDateTimeSetterProperty(\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\PhpParser\Node\Stmt\Property
    {
        $propertyFetch = $this->matchDateTimeSetterPropertyFetch($classMethod);
        if ($propertyFetch === null) {
            return null;
        }
        return $this->getPropertyByPropertyFetch($classMethod, $propertyFetch);
    }
    /**
     * Matches:
     *
     * public function setSomething(?Type $someValue);
     * {
     *      <$this->someProperty> = $someValue;
     * }
     */
    private function matchNullalbeClassMethodPropertyFetch(\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\PhpParser\Node\Expr\PropertyFetch
    {
        $propertyFetch = $this->matchSetterOnlyPropertyFetch($classMethod);
        if ($propertyFetch === null) {
            return null;
        }
        // is nullable param
        $onlyParam = $classMethod->params[0];
        if (!$this->nodeTypeResolver->isNullableObjectType($onlyParam)) {
            return null;
        }
        return $propertyFetch;
    }
    private function getPropertyByPropertyFetch(\PhpParser\Node\Stmt\ClassMethod $classMethod, \PhpParser\Node\Expr\PropertyFetch $propertyFetch) : ?\PhpParser\Node\Stmt\Property
    {
        $classLike = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \PhpParser\Node\Stmt\Class_) {
            return null;
        }
        $propertyName = $this->nodeNameResolver->getName($propertyFetch);
        if ($propertyName === null) {
            return null;
        }
        return $classLike->getProperty($propertyName);
    }
    private function matchDateTimeSetterPropertyFetch(\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\PhpParser\Node\Expr\PropertyFetch
    {
        $propertyFetch = $this->matchSetterOnlyPropertyFetch($classMethod);
        if ($propertyFetch === null) {
            return null;
        }
        $param = $classMethod->params[0];
        $paramType = $this->nodeTypeResolver->getStaticType($param);
        if (!$paramType instanceof \PHPStan\Type\TypeWithClassName) {
            return null;
        }
        if ($paramType->getClassName() !== 'DateTimeInterface') {
            return null;
        }
        return $propertyFetch;
    }
    private function matchSetterOnlyPropertyFetch(\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\PhpParser\Node\Expr\PropertyFetch
    {
        if (\count($classMethod->params) !== 1) {
            return null;
        }
        if (\count((array) $classMethod->stmts) !== 1) {
            return null;
        }
        $onlyStmt = $classMethod->stmts[0];
        if ($onlyStmt instanceof \PhpParser\Node\Stmt\Expression) {
            $onlyStmt = $onlyStmt->expr;
        }
        if (!$onlyStmt instanceof \PhpParser\Node\Expr\Assign) {
            return null;
        }
        if (!$onlyStmt->var instanceof \PhpParser\Node\Expr\PropertyFetch) {
            return null;
        }
        $propertyFetch = $onlyStmt->var;
        if (!$this->isVariableName($propertyFetch->var, 'this')) {
            return null;
        }
        return $propertyFetch;
    }
    private function isVariableName(?\PhpParser\Node $node, string $name) : bool
    {
        if (!$node instanceof \PhpParser\Node\Expr\Variable) {
            return \false;
        }
        return $this->nodeNameResolver->isName($node, $name);
    }
}
