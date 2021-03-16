<?php

declare (strict_types=1);
namespace Rector\NodeCollector\NodeCollector;

use PhpParser\Node;
use PhpParser\Node\Expr\ClassConstFetch;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeUtils;
use PHPStan\Type\UnionType;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\NodeTypeResolver\NodeTypeResolver;
final class ParsedClassConstFetchNodeCollector
{
    /**
     * @var array<string, array<string, class-string[]>>
     */
    private $classConstantFetchByClassAndName = [];
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @var ReflectionProvider
     */
    private $reflectionProvider;
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \PHPStan\Reflection\ReflectionProvider $reflectionProvider, \Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->reflectionProvider = $reflectionProvider;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function collect(\PhpParser\Node $node) : void
    {
        if (!$node instanceof \PhpParser\Node\Expr\ClassConstFetch) {
            return;
        }
        $constantName = $this->nodeNameResolver->getName($node->name);
        if ($constantName === 'class') {
            // this is not a manual constant
            return;
        }
        if ($constantName === null) {
            // this is not a manual constant
            return;
        }
        $resolvedClassType = $this->nodeTypeResolver->resolve($node->class);
        $className = $this->resolveClassTypeThatContainsConstantOrFirstUnioned($resolvedClassType, $constantName);
        if ($className === null) {
            return;
        }
        // current class
        /** @var string $classOfUse */
        $classOfUse = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        $this->classConstantFetchByClassAndName[$className][$constantName][] = $classOfUse;
        $this->classConstantFetchByClassAndName[$className][$constantName] = \array_unique($this->classConstantFetchByClassAndName[$className][$constantName]);
    }
    /**
     * @return array<string, array<string, class-string[]>>
     */
    public function getClassConstantFetchByClassAndName() : array
    {
        return $this->classConstantFetchByClassAndName;
    }
    private function resolveClassTypeThatContainsConstantOrFirstUnioned(\PHPStan\Type\Type $resolvedClassType, string $constantName) : ?string
    {
        $className = $this->matchClassTypeThatContainsConstant($resolvedClassType, $constantName);
        if ($className !== null) {
            return $className;
        }
        // we need at least one original user class
        if (!$resolvedClassType instanceof \PHPStan\Type\UnionType) {
            return null;
        }
        foreach ($resolvedClassType->getTypes() as $unionedType) {
            if (!$unionedType instanceof \PHPStan\Type\ObjectType) {
                continue;
            }
            return $unionedType->getClassName();
        }
        return null;
    }
    private function matchClassTypeThatContainsConstant(\PHPStan\Type\Type $type, string $constant) : ?string
    {
        if ($type instanceof \PHPStan\Type\ObjectType) {
            return $type->getClassName();
        }
        $classNames = \PHPStan\Type\TypeUtils::getDirectClassNames($type);
        foreach ($classNames as $className) {
            $currentClassConstants = $this->getConstantsDefinedInClass($className);
            if (!\in_array($constant, $currentClassConstants, \true)) {
                continue;
            }
            return $className;
        }
        return null;
    }
    /**
     * @return string[]
     */
    private function getConstantsDefinedInClass(string $className) : array
    {
        if (!$this->reflectionProvider->hasClass($className)) {
            return [];
        }
        $classReflection = $this->reflectionProvider->getClass($className);
        $reflectionClass = $classReflection->getNativeReflection();
        $constants = $reflectionClass->getConstants();
        $currentClassConstants = \array_keys($constants);
        if ($classReflection->getParentClass() !== \false) {
            return $currentClassConstants;
        }
        $parentClassConstants = \array_keys($constants);
        return \array_diff($currentClassConstants, $parentClassConstants);
    }
}
