<?php

declare (strict_types=1);
namespace Rector\PostRector\Rector\AbstractRector;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassConst;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Function_;
use PhpParser\Node\Stmt\Property;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
use Rector\ChangesReporting\Collector\RectorChangeCollector;
use Rector\Naming\Naming\PropertyNaming;
use Rector\NodeRemoval\NodeRemover;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\PostRector\Collector\NodesToAddCollector;
use Rector\PostRector\Collector\NodesToRemoveCollector;
use Rector\PostRector\Collector\NodesToReplaceCollector;
use Rector\PostRector\Collector\PropertyToAddCollector;
use Rector\PostRector\Collector\UseNodesToAddCollector;
use Rector\StaticTypeMapper\ValueObject\Type\AliasedObjectType;
use Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType;
/**
 * This could be part of @see AbstractRector, but decopuling to trait
 * makes clear what code has 1 purpose.
 */
trait NodeCommandersTrait
{
    /**
     * @var UseNodesToAddCollector
     */
    protected $useNodesToAddCollector;
    /**
     * @var NodesToRemoveCollector
     */
    private $nodesToRemoveCollector;
    /**
     * @var NodesToAddCollector
     */
    private $nodesToAddCollector;
    /**
     * @var PropertyToAddCollector
     */
    private $propertyToAddCollector;
    /**
     * @var NodesToReplaceCollector
     */
    private $nodesToReplaceCollector;
    /**
     * @var RectorChangeCollector
     */
    private $rectorChangeCollector;
    /**
     * @var PropertyNaming
     */
    private $propertyNaming;
    /**
     * @var NodeRemover
     */
    private $nodeRemover;
    /**
     * @required
     */
    public function autowireNodeCommandersTrait(\Rector\PostRector\Collector\NodesToRemoveCollector $nodesToRemoveCollector, \Rector\PostRector\Collector\PropertyToAddCollector $propertyToAddCollector, \Rector\PostRector\Collector\UseNodesToAddCollector $useNodesToAddCollector, \Rector\PostRector\Collector\NodesToAddCollector $nodesToAddCollector, \Rector\PostRector\Collector\NodesToReplaceCollector $nodesToReplaceCollector, \Rector\ChangesReporting\Collector\RectorChangeCollector $rectorChangeCollector, \Rector\Naming\Naming\PropertyNaming $propertyNaming, \Rector\NodeRemoval\NodeRemover $nodeRemover) : void
    {
        $this->nodesToRemoveCollector = $nodesToRemoveCollector;
        $this->propertyToAddCollector = $propertyToAddCollector;
        $this->useNodesToAddCollector = $useNodesToAddCollector;
        $this->nodesToReplaceCollector = $nodesToReplaceCollector;
        $this->nodesToAddCollector = $nodesToAddCollector;
        $this->rectorChangeCollector = $rectorChangeCollector;
        $this->propertyNaming = $propertyNaming;
        $this->nodeRemover = $nodeRemover;
    }
    protected function addUseType(\PHPStan\Type\ObjectType $objectType, \PhpParser\Node $positionNode) : void
    {
        \assert($objectType instanceof \Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType || $objectType instanceof \Rector\StaticTypeMapper\ValueObject\Type\AliasedObjectType);
        $this->useNodesToAddCollector->addUseImport($positionNode, $objectType);
    }
    /**
     * @param Node[] $newNodes
     */
    protected function addNodesAfterNode(array $newNodes, \PhpParser\Node $positionNode) : void
    {
        $this->nodesToAddCollector->addNodesAfterNode($newNodes, $positionNode);
        $this->rectorChangeCollector->notifyNodeFileInfo($positionNode);
    }
    /**
     * @param Node[] $newNodes
     */
    protected function addNodesBeforeNode(array $newNodes, \PhpParser\Node $positionNode) : void
    {
        foreach ($newNodes as $newNode) {
            $this->addNodeBeforeNode($newNode, $positionNode);
        }
    }
    protected function addNodeAfterNode(\PhpParser\Node $newNode, \PhpParser\Node $positionNode) : void
    {
        $this->nodesToAddCollector->addNodeAfterNode($newNode, $positionNode);
        $this->rectorChangeCollector->notifyNodeFileInfo($positionNode);
    }
    protected function addNodeBeforeNode(\PhpParser\Node $newNode, \PhpParser\Node $positionNode) : void
    {
        $this->nodesToAddCollector->addNodeBeforeNode($newNode, $positionNode);
        $this->rectorChangeCollector->notifyNodeFileInfo($positionNode);
    }
    protected function addPropertyToCollector(\PhpParser\Node\Stmt\Property $property) : void
    {
        $classNode = $property->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classNode instanceof \PhpParser\Node\Stmt\Class_) {
            return;
        }
        $propertyType = $this->getObjectType($property);
        // use first type - hard assumption @todo improve
        if ($propertyType instanceof \PHPStan\Type\UnionType) {
            $propertyType = $propertyType->getTypes()[0];
        }
        /** @var string $propertyName */
        $propertyName = $this->getName($property);
        $this->addConstructorDependencyToClass($classNode, $propertyType, $propertyName, $property->flags);
    }
    protected function addServiceConstructorDependencyToClass(\PhpParser\Node\Stmt\Class_ $class, string $className) : void
    {
        $serviceObjectType = new \PHPStan\Type\ObjectType($className);
        $propertyName = $this->propertyNaming->fqnToVariableName($serviceObjectType);
        $this->addConstructorDependencyToClass($class, $serviceObjectType, $propertyName);
    }
    protected function addConstructorDependencyToClass(\PhpParser\Node\Stmt\Class_ $class, ?\PHPStan\Type\Type $propertyType, string $propertyName, int $propertyFlags = 0) : void
    {
        $this->propertyToAddCollector->addPropertyToClass($class, $propertyName, $propertyType, $propertyFlags);
        $this->rectorChangeCollector->notifyNodeFileInfo($class);
    }
    protected function addConstantToClass(\PhpParser\Node\Stmt\Class_ $class, \PhpParser\Node\Stmt\ClassConst $classConst) : void
    {
        $this->propertyToAddCollector->addConstantToClass($class, $classConst);
        $this->rectorChangeCollector->notifyNodeFileInfo($class);
    }
    protected function addPropertyToClass(\PhpParser\Node\Stmt\Class_ $class, ?\PHPStan\Type\Type $propertyType, string $propertyName) : void
    {
        $this->propertyToAddCollector->addPropertyWithoutConstructorToClass($propertyName, $propertyType, $class);
        $this->rectorChangeCollector->notifyNodeFileInfo($class);
    }
    protected function removeNode(\PhpParser\Node $node) : void
    {
        $this->nodeRemover->removeNode($node);
    }
    /**
     * @param Class_|ClassMethod|Function_ $nodeWithStatements
     */
    protected function removeNodeFromStatements(\PhpParser\Node $nodeWithStatements, \PhpParser\Node $nodeToRemove) : void
    {
        $this->nodeRemover->removeNodeFromStatements($nodeWithStatements, $nodeToRemove);
    }
    protected function isNodeRemoved(\PhpParser\Node $node) : bool
    {
        return $this->nodesToRemoveCollector->isNodeRemoved($node);
    }
    /**
     * @param Node[] $nodes
     */
    protected function removeNodes(array $nodes) : void
    {
        foreach ($nodes as $node) {
            $this->removeNode($node);
        }
    }
    protected function notifyNodeFileInfo(\PhpParser\Node $node) : void
    {
        $this->rectorChangeCollector->notifyNodeFileInfo($node);
    }
}
