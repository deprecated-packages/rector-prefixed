<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PostRector\Collector;

use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassConst;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\PostRector\Contract\Collector\NodeCollectorInterface;
final class PropertyToAddCollector implements \_PhpScopere8e811afab72\Rector\PostRector\Contract\Collector\NodeCollectorInterface
{
    /**
     * @var ClassConst[][]
     */
    private $constantsByClass = [];
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var Type[][]|null[][]
     */
    private $propertiesByClass = [];
    /**
     * @var Type[][]|null[][]
     */
    private $propertiesWithoutConstructorByClass = [];
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function isActive() : bool
    {
        if ($this->propertiesByClass !== []) {
            return \true;
        }
        if ($this->propertiesWithoutConstructorByClass !== []) {
            return \true;
        }
        return $this->constantsByClass !== [];
    }
    public function addPropertyToClass(string $propertyName, ?\_PhpScopere8e811afab72\PHPStan\Type\Type $propertyType, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : void
    {
        $this->propertiesByClass[\spl_object_hash($class)][$propertyName] = $propertyType;
    }
    public function addConstantToClass(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassConst $classConst) : void
    {
        $constantName = $this->nodeNameResolver->getName($classConst);
        $this->constantsByClass[\spl_object_hash($class)][$constantName] = $classConst;
    }
    public function addPropertyWithoutConstructorToClass(string $propertyName, ?\_PhpScopere8e811afab72\PHPStan\Type\Type $propertyType, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : void
    {
        $this->propertiesWithoutConstructorByClass[\spl_object_hash($class)][$propertyName] = $propertyType;
    }
    /**
     * @var ClassConst[]
     * @return ClassConst[]
     */
    public function getConstantsByClass(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : array
    {
        $classHash = \spl_object_hash($class);
        return $this->constantsByClass[$classHash] ?? [];
    }
    /**
     * @return Type[]|null[]
     */
    public function getPropertiesByClass(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : array
    {
        $classHash = \spl_object_hash($class);
        return $this->propertiesByClass[$classHash] ?? [];
    }
    /**
     * @return Type[]|null[]
     */
    public function getPropertiesWithoutConstructorByClass(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : array
    {
        $classHash = \spl_object_hash($class);
        return $this->propertiesWithoutConstructorByClass[$classHash] ?? [];
    }
}
