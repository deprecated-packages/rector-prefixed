<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DoctrineCodeQuality\NodeAnalyzer;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function matchNullalbeClassMethodProperty(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property
    {
        $propertyFetch = $this->matchNullalbeClassMethodPropertyFetch($classMethod);
        if ($propertyFetch === null) {
            return null;
        }
        return $this->getPropertyByPropertyFetch($classMethod, $propertyFetch);
    }
    public function matchDateTimeSetterProperty(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property
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
    private function matchNullalbeClassMethodPropertyFetch(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch
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
    private function getPropertyByPropertyFetch(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch $propertyFetch) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property
    {
        $classLike = $classMethod->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_) {
            return null;
        }
        $propertyName = $this->nodeNameResolver->getName($propertyFetch);
        if ($propertyName === null) {
            return null;
        }
        return $classLike->getProperty($propertyName);
    }
    private function matchDateTimeSetterPropertyFetch(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch
    {
        $propertyFetch = $this->matchSetterOnlyPropertyFetch($classMethod);
        if ($propertyFetch === null) {
            return null;
        }
        $param = $classMethod->params[0];
        $paramType = $this->nodeTypeResolver->getStaticType($param);
        if (!$paramType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName) {
            return null;
        }
        if ($paramType->getClassName() !== 'DateTimeInterface') {
            return null;
        }
        return $propertyFetch;
    }
    private function matchSetterOnlyPropertyFetch(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch
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
        if ($onlyStmt instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression) {
            $onlyStmt = $onlyStmt->expr;
        }
        if (!$onlyStmt instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
            return null;
        }
        if (!$onlyStmt->var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch) {
            return null;
        }
        $propertyFetch = $onlyStmt->var;
        if (!$this->isVariableName($propertyFetch->var, 'this')) {
            return null;
        }
        return $propertyFetch;
    }
    private function isVariableName(?\_PhpScoperb75b35f52b74\PhpParser\Node $node, string $name) : bool
    {
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable) {
            return \false;
        }
        return $this->nodeNameResolver->isName($node, $name);
    }
}
