<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DoctrineCodeQuality\NodeAnalyzer;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
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
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function matchNullalbeClassMethodProperty(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property
    {
        $propertyFetch = $this->matchNullalbeClassMethodPropertyFetch($classMethod);
        if ($propertyFetch === null) {
            return null;
        }
        return $this->getPropertyByPropertyFetch($classMethod, $propertyFetch);
    }
    public function matchDateTimeSetterProperty(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property
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
    private function matchNullalbeClassMethodPropertyFetch(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch
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
    private function getPropertyByPropertyFetch(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch $propertyFetch) : ?\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property
    {
        $classLike = $classMethod->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_) {
            return null;
        }
        $propertyName = $this->nodeNameResolver->getName($propertyFetch);
        if ($propertyName === null) {
            return null;
        }
        return $classLike->getProperty($propertyName);
    }
    private function matchDateTimeSetterPropertyFetch(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch
    {
        $propertyFetch = $this->matchSetterOnlyPropertyFetch($classMethod);
        if ($propertyFetch === null) {
            return null;
        }
        $param = $classMethod->params[0];
        $paramType = $this->nodeTypeResolver->getStaticType($param);
        if (!$paramType instanceof \_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName) {
            return null;
        }
        if ($paramType->getClassName() !== 'DateTimeInterface') {
            return null;
        }
        return $propertyFetch;
    }
    private function matchSetterOnlyPropertyFetch(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch
    {
        if (\count((array) $classMethod->params) !== 1) {
            return null;
        }
        $stmts = (array) $classMethod->stmts;
        if (\count($stmts) !== 1) {
            return null;
        }
        $onlyStmt = $stmts[0] ?? null;
        if ($onlyStmt === null) {
            return null;
        }
        if ($onlyStmt instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression) {
            $onlyStmt = $onlyStmt->expr;
        }
        if (!$onlyStmt instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign) {
            return null;
        }
        if (!$onlyStmt->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch) {
            return null;
        }
        $propertyFetch = $onlyStmt->var;
        if (!$this->isVariableName($propertyFetch->var, 'this')) {
            return null;
        }
        return $propertyFetch;
    }
    private function isVariableName(?\_PhpScopere8e811afab72\PhpParser\Node $node, string $name) : bool
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable) {
            return \false;
        }
        return $this->nodeNameResolver->isName($node, $name);
    }
}
