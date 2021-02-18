<?php

declare (strict_types=1);
namespace Rector\Core\NodeManipulator;

use PhpParser\Node;
use PhpParser\Node\Expr\PropertyFetch;
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
final class MagicPropertyFetchAnalyzer
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var ReflectionProvider
     */
    private $reflectionProvider;
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->reflectionProvider = $reflectionProvider;
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
    private function hasPublicProperty(\PhpParser\Node\Expr\PropertyFetch $propertyFetch, string $propertyName) : bool
    {
        $scope = $propertyFetch->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if (!$scope instanceof \PHPStan\Analyser\Scope) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        $propertyFetchType = $scope->getType($propertyFetch->var);
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
        $propertyReflection = $classReflection->getProperty($propertyName, $scope);
        return $propertyReflection->isPublic();
    }
}
