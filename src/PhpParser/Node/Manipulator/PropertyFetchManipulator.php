<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider;
use _PhpScopere8e811afab72\PHPStan\Type\ErrorType;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
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
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->reflectionProvider = $reflectionProvider;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function isPropertyToSelf(\_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch $propertyFetch) : bool
    {
        if (!$this->nodeNameResolver->isName($propertyFetch->var, 'this')) {
            return \false;
        }
        /** @var Class_|null $classLike */
        $classLike = $propertyFetch->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
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
    public function isMagicOnType(\_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch $propertyFetch, \_PhpScopere8e811afab72\PHPStan\Type\Type $type) : bool
    {
        $varNodeType = $this->nodeTypeResolver->resolve($propertyFetch);
        if ($varNodeType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ErrorType) {
            return \true;
        }
        if ($varNodeType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
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
    public function isVariableAssignToThisPropertyFetch(\_PhpScopere8e811afab72\PhpParser\Node $node, string $variableName) : bool
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign) {
            return \false;
        }
        if (!$node->expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable) {
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
    public function isLocalPropertyOfNames(\_PhpScopere8e811afab72\PhpParser\Node $node, array $propertyNames) : bool
    {
        if (!$this->isLocalPropertyFetch($node)) {
            return \false;
        }
        /** @var PropertyFetch $node */
        return $this->nodeNameResolver->isNames($node->name, $propertyNames);
    }
    public function isLocalPropertyFetch(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch) {
            return \false;
        }
        return $this->nodeNameResolver->isName($node->var, 'this');
    }
    private function hasPublicProperty(\_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch $propertyFetch, string $propertyName) : bool
    {
        $nodeScope = $propertyFetch->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if ($nodeScope === null) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        $propertyFetchType = $nodeScope->getType($propertyFetch->var);
        if (!$propertyFetchType instanceof \_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName) {
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
