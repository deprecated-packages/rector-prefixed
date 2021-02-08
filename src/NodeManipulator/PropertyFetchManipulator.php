<?php

declare (strict_types=1);
namespace Rector\Core\NodeManipulator;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\ErrorType;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeWithClassName;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\NodeTypeResolver\NodeTypeResolver;
/**
 * Utils for PropertyFetch Node:
 * "$this->property"
 */
final class PropertyFetchManipulator
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @var ReflectionProvider
     */
    private $reflectionProvider;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->reflectionProvider = $reflectionProvider;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function isPropertyToSelf(\PhpParser\Node\Expr\PropertyFetch $propertyFetch) : bool
    {
        if (!$this->nodeNameResolver->isName($propertyFetch->var, 'this')) {
            return \false;
        }
        $classLike = $propertyFetch->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \PhpParser\Node\Stmt\Class_) {
            return \false;
        }
        foreach ($classLike->getProperties() as $property) {
            if (!$this->nodeNameResolver->areNamesEqual($property->props[0], $propertyFetch)) {
                continue;
            }
            return \true;
        }
        return \false;
    }
    public function isMagicOnType(\PhpParser\Node\Expr\PropertyFetch $propertyFetch, \PHPStan\Type\Type $type) : bool
    {
        $varNodeType = $this->nodeTypeResolver->resolve($propertyFetch);
        if ($varNodeType instanceof \PHPStan\Type\ErrorType) {
            return \true;
        }
        if ($varNodeType instanceof \PHPStan\Type\MixedType) {
            return \false;
        }
        if ($varNodeType->isSuperTypeOf($type)->yes()) {
            return \false;
        }
        $nodeName = $this->nodeNameResolver->getName($propertyFetch);
        if ($nodeName === null) {
            return \false;
        }
        return !$this->hasPublicProperty($propertyFetch, $nodeName);
    }
    /**
     * Matches:
     * "$this->someValue = $<variableName>;"
     */
    public function isVariableAssignToThisPropertyFetch(\PhpParser\Node $node, string $variableName) : bool
    {
        if (!$node instanceof \PhpParser\Node\Expr\Assign) {
            return \false;
        }
        if (!$node->expr instanceof \PhpParser\Node\Expr\Variable) {
            return \false;
        }
        if (!$this->nodeNameResolver->isName($node->expr, $variableName)) {
            return \false;
        }
        return $this->isLocalPropertyFetch($node->var);
    }
    /**
     * @param string[] $propertyNames
     */
    public function isLocalPropertyOfNames(\PhpParser\Node $node, array $propertyNames) : bool
    {
        if (!$this->isLocalPropertyFetch($node)) {
            return \false;
        }
        /** @var PropertyFetch $node */
        return $this->nodeNameResolver->isNames($node->name, $propertyNames);
    }
    public function isLocalPropertyFetch(\PhpParser\Node $node) : bool
    {
        if (!$node instanceof \PhpParser\Node\Expr\PropertyFetch) {
            return \false;
        }
        return $this->nodeNameResolver->isName($node->var, 'this');
    }
    private function hasPublicProperty(\PhpParser\Node\Expr\PropertyFetch $propertyFetch, string $propertyName) : bool
    {
        $nodeScope = $propertyFetch->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if (!$nodeScope instanceof \PHPStan\Analyser\Scope) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        $propertyFetchType = $nodeScope->getType($propertyFetch->var);
        if (!$propertyFetchType instanceof \PHPStan\Type\TypeWithClassName) {
            return \false;
        }
        $propertyFetchType = $propertyFetchType->getClassName();
        if (!$this->reflectionProvider->hasClass($propertyFetchType)) {
            return \false;
        }
        $classReflection = $this->reflectionProvider->getClass($propertyFetchType);
        if (!$classReflection->hasProperty($propertyName)) {
            return \false;
        }
        $propertyReflection = $classReflection->getProperty($propertyName, $nodeScope);
        return $propertyReflection->isPublic();
    }
}
