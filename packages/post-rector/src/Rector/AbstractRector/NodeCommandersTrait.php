<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\PostRector\Rector\AbstractRector;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassConst;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Function_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType;
use _PhpScoper2a4e7ab1ecbc\Rector\ChangesReporting\Collector\RectorChangeCollector;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\Naming\PropertyNaming;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeRemoval\NodeRemover;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Rector\PostRector\Collector\NodesToAddCollector;
use _PhpScoper2a4e7ab1ecbc\Rector\PostRector\Collector\NodesToRemoveCollector;
use _PhpScoper2a4e7ab1ecbc\Rector\PostRector\Collector\NodesToReplaceCollector;
use _PhpScoper2a4e7ab1ecbc\Rector\PostRector\Collector\PropertyToAddCollector;
use _PhpScoper2a4e7ab1ecbc\Rector\PostRector\Collector\UseNodesToAddCollector;
use _PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\AliasedObjectType;
use _PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType;
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
    public function autowireNodeCommandersTrait(\_PhpScoper2a4e7ab1ecbc\Rector\PostRector\Collector\NodesToRemoveCollector $nodesToRemoveCollector, \_PhpScoper2a4e7ab1ecbc\Rector\PostRector\Collector\PropertyToAddCollector $propertyToAddCollector, \_PhpScoper2a4e7ab1ecbc\Rector\PostRector\Collector\UseNodesToAddCollector $useNodesToAddCollector, \_PhpScoper2a4e7ab1ecbc\Rector\PostRector\Collector\NodesToAddCollector $nodesToAddCollector, \_PhpScoper2a4e7ab1ecbc\Rector\PostRector\Collector\NodesToReplaceCollector $nodesToReplaceCollector, \_PhpScoper2a4e7ab1ecbc\Rector\ChangesReporting\Collector\RectorChangeCollector $rectorChangeCollector, \_PhpScoper2a4e7ab1ecbc\Rector\Naming\Naming\PropertyNaming $propertyNaming, \_PhpScoper2a4e7ab1ecbc\Rector\NodeRemoval\NodeRemover $nodeRemover) : void
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
    protected function addUseType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType $objectType, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node $positionNode) : void
    {
        \assert($objectType instanceof \_PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType || $objectType instanceof \_PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\AliasedObjectType);
        $this->useNodesToAddCollector->addUseImport($positionNode, $objectType);
    }
    /**
     * @param Node[] $newNodes
     */
    protected function addNodesAfterNode(array $newNodes, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node $positionNode) : void
    {
        $this->nodesToAddCollector->addNodesAfterNode($newNodes, $positionNode);
        $this->rectorChangeCollector->notifyNodeFileInfo($positionNode);
    }
    /**
     * @param Node[] $newNodes
     */
    protected function addNodesBeforeNode(array $newNodes, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node $positionNode) : void
    {
        foreach ($newNodes as $newNode) {
            $this->addNodeBeforeNode($newNode, $positionNode);
        }
    }
    protected function addNodeAfterNode(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $newNode, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node $positionNode) : void
    {
        $this->nodesToAddCollector->addNodeAfterNode($newNode, $positionNode);
        $this->rectorChangeCollector->notifyNodeFileInfo($positionNode);
    }
    protected function addNodeBeforeNode(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $newNode, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node $positionNode) : void
    {
        $this->nodesToAddCollector->addNodeBeforeNode($newNode, $positionNode);
        $this->rectorChangeCollector->notifyNodeFileInfo($positionNode);
    }
    protected function addPropertyToCollector(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property $property) : void
    {
        $classNode = $property->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classNode instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_) {
            return;
        }
        $propertyType = $this->getObjectType($property);
        // use first type - hard assumption @todo improve
        if ($propertyType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType) {
            $propertyType = $propertyType->getTypes()[0];
        }
        /** @var string $propertyName */
        $propertyName = $this->getName($property);
        $this->addConstructorDependencyToClass($classNode, $propertyType, $propertyName);
    }
    protected function addServiceConstructorDependencyToClass(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_ $class, string $className) : void
    {
        $serviceObjectType = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType($className);
        $propertyName = $this->propertyNaming->fqnToVariableName($serviceObjectType);
        $this->addConstructorDependencyToClass($class, $serviceObjectType, $propertyName);
    }
    protected function addConstructorDependencyToClass(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_ $class, ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $propertyType, string $propertyName) : void
    {
        $this->propertyToAddCollector->addPropertyToClass($propertyName, $propertyType, $class);
        $this->rectorChangeCollector->notifyNodeFileInfo($class);
    }
    protected function addConstantToClass(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_ $class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassConst $classConst) : void
    {
        $this->propertyToAddCollector->addConstantToClass($class, $classConst);
        $this->rectorChangeCollector->notifyNodeFileInfo($class);
    }
    protected function addPropertyToClass(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_ $class, ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $propertyType, string $propertyName) : void
    {
        $this->propertyToAddCollector->addPropertyWithoutConstructorToClass($propertyName, $propertyType, $class);
        $this->rectorChangeCollector->notifyNodeFileInfo($class);
    }
    protected function removeNode(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : void
    {
        $this->nodeRemover->removeNode($node);
    }
    /**
     * @param Class_|ClassMethod|Function_ $nodeWithStatements
     */
    protected function removeNodeFromStatements(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $nodeWithStatements, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node $nodeToRemove) : void
    {
        foreach ((array) $nodeWithStatements->stmts as $key => $stmt) {
            if ($nodeToRemove !== $stmt) {
                continue;
            }
            unset($nodeWithStatements->stmts[$key]);
            break;
        }
    }
    protected function isNodeRemoved(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : bool
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
    protected function notifyNodeFileInfo(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : void
    {
        $this->rectorChangeCollector->notifyNodeFileInfo($node);
    }
}
