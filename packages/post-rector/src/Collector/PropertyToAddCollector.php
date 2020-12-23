<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\PostRector\Collector;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassConst;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a2ac50786fa\Rector\PostRector\Contract\Collector\NodeCollectorInterface;
final class PropertyToAddCollector implements \_PhpScoper0a2ac50786fa\Rector\PostRector\Contract\Collector\NodeCollectorInterface
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
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
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
    public function addPropertyToClass(string $propertyName, ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $propertyType, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $class) : void
    {
        $this->propertiesByClass[\spl_object_hash($class)][$propertyName] = $propertyType;
    }
    public function addConstantToClass(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassConst $classConst) : void
    {
        $constantName = $this->nodeNameResolver->getName($classConst);
        $this->constantsByClass[\spl_object_hash($class)][$constantName] = $classConst;
    }
    public function addPropertyWithoutConstructorToClass(string $propertyName, ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $propertyType, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $class) : void
    {
        $this->propertiesWithoutConstructorByClass[\spl_object_hash($class)][$propertyName] = $propertyType;
    }
    /**
     * @var ClassConst[]
     * @return ClassConst[]
     */
    public function getConstantsByClass(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $class) : array
    {
        $classHash = \spl_object_hash($class);
        return $this->constantsByClass[$classHash] ?? [];
    }
    /**
     * @return Type[]|null[]
     */
    public function getPropertiesByClass(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $class) : array
    {
        $classHash = \spl_object_hash($class);
        return $this->propertiesByClass[$classHash] ?? [];
    }
    /**
     * @return Type[]|null[]
     */
    public function getPropertiesWithoutConstructorByClass(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $class) : array
    {
        $classHash = \spl_object_hash($class);
        return $this->propertiesWithoutConstructorByClass[$classHash] ?? [];
    }
}
