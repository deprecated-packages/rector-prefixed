<?php

declare (strict_types=1);
namespace Rector\PostRector\Collector;

use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassConst;
use PHPStan\Type\Type;
use Rector\ChangesReporting\Collector\RectorChangeCollector;
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
     * @var array<string, array<string, Type>>
     */
    private $propertiesWithoutConstructorByClass = [];
    /**
     * @var RectorChangeCollector
     */
    private $rectorChangeCollector;
    /**
     * @param \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver
     * @param \Rector\ChangesReporting\Collector\RectorChangeCollector $rectorChangeCollector
     */
    public function __construct($nodeNameResolver, $rectorChangeCollector)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->rectorChangeCollector = $rectorChangeCollector;
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
    /**
     * @param \PhpParser\Node\Stmt\Class_ $class
     * @param string $propertyName
     * @param \PHPStan\Type\Type|null $propertyType
     * @param int $propertyFlags
     */
    public function addPropertyToClass($class, $propertyName, $propertyType, $propertyFlags) : void
    {
        $uniqueHash = \spl_object_hash($class);
        $this->propertiesByClass[$uniqueHash][] = new \Rector\PostRector\ValueObject\PropertyMetadata($propertyName, $propertyType, $propertyFlags);
    }
    /**
     * @param \PhpParser\Node\Stmt\Class_ $class
     * @param \PhpParser\Node\Stmt\ClassConst $classConst
     */
    public function addConstantToClass($class, $classConst) : void
    {
        $constantName = $this->nodeNameResolver->getName($classConst);
        $this->constantsByClass[\spl_object_hash($class)][$constantName] = $classConst;
        $this->rectorChangeCollector->notifyNodeFileInfo($class);
    }
    /**
     * @param string $propertyName
     * @param \PHPStan\Type\Type|null $propertyType
     * @param \PhpParser\Node\Stmt\Class_ $class
     */
    public function addPropertyWithoutConstructorToClass($propertyName, $propertyType, $class) : void
    {
        $this->propertiesWithoutConstructorByClass[\spl_object_hash($class)][$propertyName] = $propertyType;
        $this->rectorChangeCollector->notifyNodeFileInfo($class);
    }
    /**
     * @return ClassConst[]
     * @param \PhpParser\Node\Stmt\Class_ $class
     */
    public function getConstantsByClass($class) : array
    {
        $classHash = \spl_object_hash($class);
        return $this->constantsByClass[$classHash] ?? [];
    }
    /**
     * @return PropertyMetadata[]
     * @param \PhpParser\Node\Stmt\Class_ $class
     */
    public function getPropertiesByClass($class) : array
    {
        $classHash = \spl_object_hash($class);
        return $this->propertiesByClass[$classHash] ?? [];
    }
    /**
     * @return array<string, Type>
     * @param \PhpParser\Node\Stmt\Class_ $class
     */
    public function getPropertiesWithoutConstructorByClass($class) : array
    {
        $classHash = \spl_object_hash($class);
        return $this->propertiesWithoutConstructorByClass[$classHash] ?? [];
    }
}
