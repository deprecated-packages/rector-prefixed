<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypeUtils;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
use ReflectionClass;
final class ParsedClassConstFetchNodeCollector
{
    /**
     * @var string[][][]
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
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * To prevent circular reference
     * @required
     */
    public function autowireParsedClassConstFetchNodeCollector(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver) : void
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function collect(\_PhpScopere8e811afab72\PhpParser\Node $node) : void
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch) {
            return;
        }
        $constantName = $this->nodeNameResolver->getName($node->name);
        if ($constantName === 'class' || $constantName === null) {
            // this is not a manual constant
            return;
        }
        $resolvedClassType = $this->nodeTypeResolver->resolve($node->class);
        $className = $this->resolveClassTypeThatContainsConstantOrFirstUnioned($resolvedClassType, $constantName);
        if ($className === null) {
            return;
        }
        // current class
        $classOfUse = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        $this->classConstantFetchByClassAndName[$className][$constantName][] = $classOfUse;
        $this->classConstantFetchByClassAndName[$className][$constantName] = \array_unique($this->classConstantFetchByClassAndName[$className][$constantName]);
    }
    /**
     * @return string[][][]
     */
    public function getClassConstantFetchByClassAndName() : array
    {
        return $this->classConstantFetchByClassAndName;
    }
    private function resolveClassTypeThatContainsConstantOrFirstUnioned(\_PhpScopere8e811afab72\PHPStan\Type\Type $resolvedClassType, string $constantName) : ?string
    {
        $className = $this->matchClassTypeThatContainsConstant($resolvedClassType, $constantName);
        if ($className !== null) {
            return $className;
        }
        // we need at least one original user class
        if (!$resolvedClassType instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
            return null;
        }
        foreach ($resolvedClassType->getTypes() as $unionedType) {
            if (!$unionedType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ObjectType) {
                continue;
            }
            return $unionedType->getClassName();
        }
        return null;
    }
    private function matchClassTypeThatContainsConstant(\_PhpScopere8e811afab72\PHPStan\Type\Type $type, string $constant) : ?string
    {
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\ObjectType) {
            return $type->getClassName();
        }
        $classNames = \_PhpScopere8e811afab72\PHPStan\Type\TypeUtils::getDirectClassNames($type);
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
        $reflectionClass = new \ReflectionClass($className);
        $constants = (array) $reflectionClass->getConstants();
        $currentClassConstants = \array_keys($constants);
        $parentClassReflection = $reflectionClass->getParentClass();
        if (!$parentClassReflection) {
            return $currentClassConstants;
        }
        $parentClassConstants = \array_keys($constants);
        return \array_diff($currentClassConstants, $parentClassConstants);
    }
}
