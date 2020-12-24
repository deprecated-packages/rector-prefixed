<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PostRector\Rector\AbstractRector;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassConst;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Function_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\UnionType;
use _PhpScoperb75b35f52b74\Rector\ChangesReporting\Collector\RectorChangeCollector;
use _PhpScoperb75b35f52b74\Rector\Naming\Naming\PropertyNaming;
use _PhpScoperb75b35f52b74\Rector\NodeRemoval\NodeRemover;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\AliasedObjectType;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType;
use _PhpScoperb75b35f52b74\Rector\PostRector\Collector\NodesToAddCollector;
use _PhpScoperb75b35f52b74\Rector\PostRector\Collector\NodesToRemoveCollector;
use _PhpScoperb75b35f52b74\Rector\PostRector\Collector\NodesToReplaceCollector;
use _PhpScoperb75b35f52b74\Rector\PostRector\Collector\PropertyToAddCollector;
use _PhpScoperb75b35f52b74\Rector\PostRector\Collector\UseNodesToAddCollector;
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
    public function autowireNodeCommandersTrait(\_PhpScoperb75b35f52b74\Rector\PostRector\Collector\NodesToRemoveCollector $nodesToRemoveCollector, \_PhpScoperb75b35f52b74\Rector\PostRector\Collector\PropertyToAddCollector $propertyToAddCollector, \_PhpScoperb75b35f52b74\Rector\PostRector\Collector\UseNodesToAddCollector $useNodesToAddCollector, \_PhpScoperb75b35f52b74\Rector\PostRector\Collector\NodesToAddCollector $nodesToAddCollector, \_PhpScoperb75b35f52b74\Rector\PostRector\Collector\NodesToReplaceCollector $nodesToReplaceCollector, \_PhpScoperb75b35f52b74\Rector\ChangesReporting\Collector\RectorChangeCollector $rectorChangeCollector, \_PhpScoperb75b35f52b74\Rector\Naming\Naming\PropertyNaming $propertyNaming, \_PhpScoperb75b35f52b74\Rector\NodeRemoval\NodeRemover $nodeRemover) : void
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
    protected function addUseType(\_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType $objectType, \_PhpScoperb75b35f52b74\PhpParser\Node $positionNode) : void
    {
        \assert($objectType instanceof \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType || $objectType instanceof \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\AliasedObjectType);
        $this->useNodesToAddCollector->addUseImport($positionNode, $objectType);
    }
    /**
     * @param Node[] $newNodes
     */
    protected function addNodesAfterNode(array $newNodes, \_PhpScoperb75b35f52b74\PhpParser\Node $positionNode) : void
    {
        $this->nodesToAddCollector->addNodesAfterNode($newNodes, $positionNode);
        $this->rectorChangeCollector->notifyNodeFileInfo($positionNode);
    }
    /**
     * @param Node[] $newNodes
     */
    protected function addNodesBeforeNode(array $newNodes, \_PhpScoperb75b35f52b74\PhpParser\Node $positionNode) : void
    {
        foreach ($newNodes as $newNode) {
            $this->addNodeBeforeNode($newNode, $positionNode);
        }
    }
    protected function addNodeAfterNode(\_PhpScoperb75b35f52b74\PhpParser\Node $newNode, \_PhpScoperb75b35f52b74\PhpParser\Node $positionNode) : void
    {
        $this->nodesToAddCollector->addNodeAfterNode($newNode, $positionNode);
        $this->rectorChangeCollector->notifyNodeFileInfo($positionNode);
    }
    protected function addNodeBeforeNode(\_PhpScoperb75b35f52b74\PhpParser\Node $newNode, \_PhpScoperb75b35f52b74\PhpParser\Node $positionNode) : void
    {
        $this->nodesToAddCollector->addNodeBeforeNode($newNode, $positionNode);
        $this->rectorChangeCollector->notifyNodeFileInfo($positionNode);
    }
    protected function addPropertyToCollector(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property $property) : void
    {
        $classNode = $property->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_) {
            return;
        }
        $propertyType = $this->getObjectType($property);
        // use first type - hard assumption @todo improve
        if ($propertyType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType) {
            $propertyType = $propertyType->getTypes()[0];
        }
        /** @var string $propertyName */
        $propertyName = $this->getName($property);
        $this->addConstructorDependencyToClass($classNode, $propertyType, $propertyName);
    }
    protected function addServiceConstructorDependencyToClass(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class, string $className) : void
    {
        $serviceObjectType = new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($className);
        $propertyName = $this->propertyNaming->fqnToVariableName($serviceObjectType);
        $this->addConstructorDependencyToClass($class, $serviceObjectType, $propertyName);
    }
    protected function addConstructorDependencyToClass(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class, ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type $propertyType, string $propertyName) : void
    {
        $this->propertyToAddCollector->addPropertyToClass($propertyName, $propertyType, $class);
        $this->rectorChangeCollector->notifyNodeFileInfo($class);
    }
    protected function addConstantToClass(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassConst $classConst) : void
    {
        $this->propertyToAddCollector->addConstantToClass($class, $classConst);
        $this->rectorChangeCollector->notifyNodeFileInfo($class);
    }
    protected function addPropertyToClass(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class, ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type $propertyType, string $propertyName) : void
    {
        $this->propertyToAddCollector->addPropertyWithoutConstructorToClass($propertyName, $propertyType, $class);
        $this->rectorChangeCollector->notifyNodeFileInfo($class);
    }
    protected function removeNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : void
    {
        $this->nodeRemover->removeNode($node);
    }
    /**
     * @param Class_|ClassMethod|Function_ $nodeWithStatements
     */
    protected function removeNodeFromStatements(\_PhpScoperb75b35f52b74\PhpParser\Node $nodeWithStatements, \_PhpScoperb75b35f52b74\PhpParser\Node $nodeToRemove) : void
    {
        foreach ((array) $nodeWithStatements->stmts as $key => $stmt) {
            if ($nodeToRemove !== $stmt) {
                continue;
            }
            unset($nodeWithStatements->stmts[$key]);
            break;
        }
    }
    protected function isNodeRemoved(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
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
    protected function notifyNodeFileInfo(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : void
    {
        $this->rectorChangeCollector->notifyNodeFileInfo($node);
    }
}
