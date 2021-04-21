<?php

declare(strict_types=1);

namespace Rector\PostRector\Collector;

use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassConst;
use PHPStan\Type\Type;
use Rector\ChangesReporting\Collector\RectorChangeCollector;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\PostRector\Contract\Collector\NodeCollectorInterface;
use Rector\PostRector\ValueObject\PropertyMetadata;

final class PropertyToAddCollector implements NodeCollectorInterface
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

    public function __construct(NodeNameResolver $nodeNameResolver, RectorChangeCollector $rectorChangeCollector)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->rectorChangeCollector = $rectorChangeCollector;
    }

    public function isActive(): bool
    {
        if ($this->propertiesByClass !== []) {
            return true;
        }

        if ($this->propertiesWithoutConstructorByClass !== []) {
            return true;
        }

        return $this->constantsByClass !== [];
    }

    /**
     * @param \PHPStan\Type\Type|null $propertyType
     * @return void
     */
    public function addPropertyToClass(
        Class_ $class,
        string $propertyName,
        $propertyType,
        int $propertyFlags
    ) {
        $uniqueHash = spl_object_hash($class);
        $this->propertiesByClass[$uniqueHash][] = new PropertyMetadata($propertyName, $propertyType, $propertyFlags);
    }

    /**
     * @return void
     */
    public function addConstantToClass(Class_ $class, ClassConst $classConst)
    {
        $constantName = $this->nodeNameResolver->getName($classConst);
        $this->constantsByClass[spl_object_hash($class)][$constantName] = $classConst;

        $this->rectorChangeCollector->notifyNodeFileInfo($class);
    }

    /**
     * @param \PHPStan\Type\Type|null $propertyType
     * @return void
     */
    public function addPropertyWithoutConstructorToClass(
        string $propertyName,
        $propertyType,
        Class_ $class
    ) {
        $this->propertiesWithoutConstructorByClass[spl_object_hash($class)][$propertyName] = $propertyType;

        $this->rectorChangeCollector->notifyNodeFileInfo($class);
    }

    /**
     * @return ClassConst[]
     */
    public function getConstantsByClass(Class_ $class): array
    {
        $classHash = spl_object_hash($class);
        return $this->constantsByClass[$classHash] ?? [];
    }

    /**
     * @return PropertyMetadata[]
     */
    public function getPropertiesByClass(Class_ $class): array
    {
        $classHash = spl_object_hash($class);
        return $this->propertiesByClass[$classHash] ?? [];
    }

    /**
     * @return array<string, Type>
     */
    public function getPropertiesWithoutConstructorByClass(Class_ $class): array
    {
        $classHash = spl_object_hash($class);
        return $this->propertiesWithoutConstructorByClass[$classHash] ?? [];
    }
}
