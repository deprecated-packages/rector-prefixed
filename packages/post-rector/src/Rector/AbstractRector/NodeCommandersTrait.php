<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\PostRector\Rector\AbstractRector;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassConst;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Function_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\UnionType;
use _PhpScoper0a2ac50786fa\Rector\ChangesReporting\Collector\RectorChangeCollector;
use _PhpScoper0a2ac50786fa\Rector\Naming\Naming\PropertyNaming;
use _PhpScoper0a2ac50786fa\Rector\NodeRemoval\NodeRemover;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Rector\PHPStan\Type\AliasedObjectType;
use _PhpScoper0a2ac50786fa\Rector\PHPStan\Type\FullyQualifiedObjectType;
use _PhpScoper0a2ac50786fa\Rector\PostRector\Collector\NodesToAddCollector;
use _PhpScoper0a2ac50786fa\Rector\PostRector\Collector\NodesToRemoveCollector;
use _PhpScoper0a2ac50786fa\Rector\PostRector\Collector\NodesToReplaceCollector;
use _PhpScoper0a2ac50786fa\Rector\PostRector\Collector\PropertyToAddCollector;
use _PhpScoper0a2ac50786fa\Rector\PostRector\Collector\UseNodesToAddCollector;
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
    public function autowireNodeCommandersTrait(\_PhpScoper0a2ac50786fa\Rector\PostRector\Collector\NodesToRemoveCollector $nodesToRemoveCollector, \_PhpScoper0a2ac50786fa\Rector\PostRector\Collector\PropertyToAddCollector $propertyToAddCollector, \_PhpScoper0a2ac50786fa\Rector\PostRector\Collector\UseNodesToAddCollector $useNodesToAddCollector, \_PhpScoper0a2ac50786fa\Rector\PostRector\Collector\NodesToAddCollector $nodesToAddCollector, \_PhpScoper0a2ac50786fa\Rector\PostRector\Collector\NodesToReplaceCollector $nodesToReplaceCollector, \_PhpScoper0a2ac50786fa\Rector\ChangesReporting\Collector\RectorChangeCollector $rectorChangeCollector, \_PhpScoper0a2ac50786fa\Rector\Naming\Naming\PropertyNaming $propertyNaming, \_PhpScoper0a2ac50786fa\Rector\NodeRemoval\NodeRemover $nodeRemover) : void
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
    protected function addUseType(\_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType $objectType, \_PhpScoper0a2ac50786fa\PhpParser\Node $positionNode) : void
    {
        \assert($objectType instanceof \_PhpScoper0a2ac50786fa\Rector\PHPStan\Type\FullyQualifiedObjectType || $objectType instanceof \_PhpScoper0a2ac50786fa\Rector\PHPStan\Type\AliasedObjectType);
        $this->useNodesToAddCollector->addUseImport($positionNode, $objectType);
    }
    /**
     * @param Node[] $newNodes
     */
    protected function addNodesAfterNode(array $newNodes, \_PhpScoper0a2ac50786fa\PhpParser\Node $positionNode) : void
    {
        $this->nodesToAddCollector->addNodesAfterNode($newNodes, $positionNode);
        $this->rectorChangeCollector->notifyNodeFileInfo($positionNode);
    }
    /**
     * @param Node[] $newNodes
     */
    protected function addNodesBeforeNode(array $newNodes, \_PhpScoper0a2ac50786fa\PhpParser\Node $positionNode) : void
    {
        foreach ($newNodes as $newNode) {
            $this->addNodeBeforeNode($newNode, $positionNode);
        }
    }
    protected function addNodeAfterNode(\_PhpScoper0a2ac50786fa\PhpParser\Node $newNode, \_PhpScoper0a2ac50786fa\PhpParser\Node $positionNode) : void
    {
        $this->nodesToAddCollector->addNodeAfterNode($newNode, $positionNode);
        $this->rectorChangeCollector->notifyNodeFileInfo($positionNode);
    }
    protected function addNodeBeforeNode(\_PhpScoper0a2ac50786fa\PhpParser\Node $newNode, \_PhpScoper0a2ac50786fa\PhpParser\Node $positionNode) : void
    {
        $this->nodesToAddCollector->addNodeBeforeNode($newNode, $positionNode);
        $this->rectorChangeCollector->notifyNodeFileInfo($positionNode);
    }
    protected function addPropertyToCollector(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property $property) : void
    {
        $classNode = $property->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_) {
            return;
        }
        $propertyType = $this->getObjectType($property);
        // use first type - hard assumption @todo improve
        if ($propertyType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\UnionType) {
            $propertyType = $propertyType->getTypes()[0];
        }
        /** @var string $propertyName */
        $propertyName = $this->getName($property);
        $this->addConstructorDependencyToClass($classNode, $propertyType, $propertyName);
    }
    protected function addServiceConstructorDependencyToClass(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $class, string $className) : void
    {
        $serviceObjectType = new \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType($className);
        $propertyName = $this->propertyNaming->fqnToVariableName($serviceObjectType);
        $this->addConstructorDependencyToClass($class, $serviceObjectType, $propertyName);
    }
    protected function addConstructorDependencyToClass(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $class, ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $propertyType, string $propertyName) : void
    {
        $this->propertyToAddCollector->addPropertyToClass($propertyName, $propertyType, $class);
        $this->rectorChangeCollector->notifyNodeFileInfo($class);
    }
    protected function addConstantToClass(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassConst $classConst) : void
    {
        $this->propertyToAddCollector->addConstantToClass($class, $classConst);
        $this->rectorChangeCollector->notifyNodeFileInfo($class);
    }
    protected function addPropertyToClass(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $class, ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $propertyType, string $propertyName) : void
    {
        $this->propertyToAddCollector->addPropertyWithoutConstructorToClass($propertyName, $propertyType, $class);
        $this->rectorChangeCollector->notifyNodeFileInfo($class);
    }
    protected function removeNode(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : void
    {
        $this->nodeRemover->removeNode($node);
    }
    /**
     * @param Class_|ClassMethod|Function_ $nodeWithStatements
     */
    protected function removeNodeFromStatements(\_PhpScoper0a2ac50786fa\PhpParser\Node $nodeWithStatements, \_PhpScoper0a2ac50786fa\PhpParser\Node $nodeToRemove) : void
    {
        foreach ((array) $nodeWithStatements->stmts as $key => $stmt) {
            if ($nodeToRemove !== $stmt) {
                continue;
            }
            unset($nodeWithStatements->stmts[$key]);
            break;
        }
    }
    protected function isNodeRemoved(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool
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
    protected function notifyNodeFileInfo(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : void
    {
        $this->rectorChangeCollector->notifyNodeFileInfo($node);
    }
}
