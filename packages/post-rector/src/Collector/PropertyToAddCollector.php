<?php

declare (strict_types=1);
namespace Rector\PostRector\Collector;

use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassConst;
use PHPStan\Type\Type;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\PostRector\Contract\Collector\NodeCollectorInterface;
use Rector\PostRector\ValueObject\PropertyMetadata;
final class PropertyToAddCollector implements \Rector\PostRector\Contract\Collector\NodeCollectorInterface
{
    /**
     * @var array<string, array<string, ClassConst>>
     */
    private $constantsByClass = [];
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var array<string, PropertyMetadata[]>
     */
    private $propertiesByClass = [];
    /**
     * @var Type[][]|null[][]
     */
    private $propertiesWithoutConstructorByClass = [];
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
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
    public function addPropertyToClass(\PhpParser\Node\Stmt\Class_ $class, string $propertyName, ?\PHPStan\Type\Type $propertyType, int $propertyFlags) : void
    {
        $uniqueHash = \spl_object_hash($class);
        $this->propertiesByClass[$uniqueHash][] = new \Rector\PostRector\ValueObject\PropertyMetadata($propertyName, $propertyType, $propertyFlags);
    }
    public function addConstantToClass(\PhpParser\Node\Stmt\Class_ $class, \PhpParser\Node\Stmt\ClassConst $classConst) : void
    {
        $constantName = $this->nodeNameResolver->getName($classConst);
        $this->constantsByClass[\spl_object_hash($class)][$constantName] = $classConst;
    }
    public function addPropertyWithoutConstructorToClass(string $propertyName, ?\PHPStan\Type\Type $propertyType, \PhpParser\Node\Stmt\Class_ $class) : void
    {
        $this->propertiesWithoutConstructorByClass[\spl_object_hash($class)][$propertyName] = $propertyType;
    }
    /**
     * @return ClassConst[]
     */
    public function getConstantsByClass(\PhpParser\Node\Stmt\Class_ $class) : array
    {
        $classHash = \spl_object_hash($class);
        return $this->constantsByClass[$classHash] ?? [];
    }
    /**
     * @return PropertyMetadata[]
     */
    public function getPropertiesByClass(\PhpParser\Node\Stmt\Class_ $class) : array
    {
        $classHash = \spl_object_hash($class);
        return $this->propertiesByClass[$classHash] ?? [];
    }
    /**
     * @return Type[]|null[]
     */
    public function getPropertiesWithoutConstructorByClass(\PhpParser\Node\Stmt\Class_ $class) : array
    {
        $classHash = \spl_object_hash($class);
        return $this->propertiesWithoutConstructorByClass[$classHash] ?? [];
    }
}
