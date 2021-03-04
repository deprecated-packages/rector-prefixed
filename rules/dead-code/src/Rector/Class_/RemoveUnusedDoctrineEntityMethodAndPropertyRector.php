<?php

declare (strict_types=1);
namespace Rector\DeadCode\Rector\Class_;

use RectorPrefix20210304\Doctrine\Common\Collections\ArrayCollection;
use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Property;
use Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\IdTagValueNode;
use Rector\Caching\Contract\Rector\ZeroCacheRectorInterface;
use Rector\Core\NodeManipulator\ClassManipulator;
use Rector\Core\Rector\AbstractRector;
use Rector\DeadCode\Doctrine\DoctrineEntityManipulator;
use Rector\DeadCode\UnusedNodeResolver\ClassUnusedPrivateClassMethodResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://spaceflow.io/ for sponsoring this rule - visit them on https://github.com/SpaceFlow-app
 * @see \Rector\DeadCode\Tests\Rector\Class_\RemoveUnusedDoctrineEntityMethodAndPropertyRector\RemoveUnusedDoctrineEntityMethodAndPropertyRectorTest
 */
final class RemoveUnusedDoctrineEntityMethodAndPropertyRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Caching\Contract\Rector\ZeroCacheRectorInterface
{
    /**
     * @var Assign[]
     */
    private $collectionByPropertyName = [];
    /**
     * @var ClassUnusedPrivateClassMethodResolver
     */
    private $classUnusedPrivateClassMethodResolver;
    /**
     * @var ClassManipulator
     */
    private $classManipulator;
    /**
     * @var DoctrineEntityManipulator
     */
    private $doctrineEntityManipulator;
    public function __construct(\Rector\Core\NodeManipulator\ClassManipulator $classManipulator, \Rector\DeadCode\UnusedNodeResolver\ClassUnusedPrivateClassMethodResolver $classUnusedPrivateClassMethodResolver, \Rector\DeadCode\Doctrine\DoctrineEntityManipulator $doctrineEntityManipulator)
    {
        $this->classUnusedPrivateClassMethodResolver = $classUnusedPrivateClassMethodResolver;
        $this->classManipulator = $classManipulator;
        $this->doctrineEntityManipulator = $doctrineEntityManipulator;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Removes unused methods and properties from Doctrine entity classes', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class UserEntity
{
    /**
     * @ORM\Column
     */
    private $name;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class UserEntity
{
}
CODE_SAMPLE
)]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->doctrineEntityManipulator->isNonAbstractDoctrineEntityClass($node)) {
            return null;
        }
        $unusedMethodNames = $this->classUnusedPrivateClassMethodResolver->getClassUnusedMethodNames($node);
        if ($unusedMethodNames !== []) {
            $node = $this->removeClassMethodsByNames($node, $unusedMethodNames);
        }
        $unusedPropertyNames = $this->resolveUnusedPrivatePropertyNames($node);
        if ($unusedPropertyNames !== []) {
            $node = $this->removeClassPrivatePropertiesByNames($node, $unusedPropertyNames);
        }
        return $node;
    }
    /**
     * Remove unused methods immediately, so we can then remove unused properties.
     * @param string[] $unusedMethodNames
     */
    private function removeClassMethodsByNames(\PhpParser\Node\Stmt\Class_ $class, array $unusedMethodNames) : \PhpParser\Node\Stmt\Class_
    {
        foreach ($class->getMethods() as $classMethod) {
            if (!$this->isNames($classMethod, $unusedMethodNames)) {
                continue;
            }
            $this->removeNodeFromStatements($class, $classMethod);
        }
        return $class;
    }
    /**
     * @return string[]
     */
    private function resolveUnusedPrivatePropertyNames(\PhpParser\Node\Stmt\Class_ $class) : array
    {
        $privatePropertyNames = $this->classManipulator->getPrivatePropertyNames($class);
        // get list of fetched properties
        $usedPropertyNames = $this->resolveClassUsedPropertyFetchNames($class);
        return \array_diff($privatePropertyNames, $usedPropertyNames);
    }
    /**
     * @param string[] $unusedPropertyNames
     */
    private function removeClassPrivatePropertiesByNames(\PhpParser\Node\Stmt\Class_ $class, array $unusedPropertyNames) : \PhpParser\Node\Stmt\Class_
    {
        foreach ($class->getProperties() as $property) {
            $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($property);
            if ($phpDocInfo->hasByType(\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\IdTagValueNode::class)) {
                continue;
            }
            if (!$this->isNames($property, $unusedPropertyNames)) {
                continue;
            }
            $this->removeNodeFromStatements($class, $property);
            // remove "$this->someProperty = new ArrayCollection()"
            $propertyName = $this->getName($property);
            if (isset($this->collectionByPropertyName[$propertyName])) {
                $this->removeNode($this->collectionByPropertyName[$propertyName]);
            }
            $this->removeInversedByOrMappedByOnRelatedProperty($phpDocInfo, $property);
        }
        return $class;
    }
    /**
     * @return string[]
     */
    private function resolveClassUsedPropertyFetchNames(\PhpParser\Node\Stmt\Class_ $class) : array
    {
        $usedPropertyNames = [];
        $this->traverseNodesWithCallable($class->stmts, function (\PhpParser\Node $node) use(&$usedPropertyNames) {
            if (!$node instanceof \PhpParser\Node\Expr\PropertyFetch) {
                return null;
            }
            if (!$this->isName($node->var, 'this')) {
                return null;
            }
            /** @var string $propertyName */
            $propertyName = $this->getName($node->name);
            // skip collection initialization, e.g. "$this->someProperty = new ArrayCollection();"
            if ($this->isPropertyFetchAssignOfArrayCollection($node)) {
                /** @var Assign $parentNode */
                $parentNode = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
                $this->collectionByPropertyName[$propertyName] = $parentNode;
                return null;
            }
            $usedPropertyNames[] = $propertyName;
            return null;
        });
        return $usedPropertyNames;
    }
    private function removeInversedByOrMappedByOnRelatedProperty(\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo, \PhpParser\Node\Stmt\Property $property) : void
    {
        $otherRelationProperty = $this->getOtherRelationProperty($phpDocInfo, $property);
        if (!$otherRelationProperty instanceof \PhpParser\Node\Stmt\Property) {
            return;
        }
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($otherRelationProperty);
        $this->doctrineEntityManipulator->removeMappedByOrInversedByFromProperty($phpDocInfo);
    }
    private function isPropertyFetchAssignOfArrayCollection(\PhpParser\Node\Expr\PropertyFetch $propertyFetch) : bool
    {
        $parentNode = $propertyFetch->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentNode instanceof \PhpParser\Node\Expr\Assign) {
            return \false;
        }
        if (!$parentNode->expr instanceof \PhpParser\Node\Expr\New_) {
            return \false;
        }
        /** @var New_ $new */
        $new = $parentNode->expr;
        return $this->isName($new->class, \RectorPrefix20210304\Doctrine\Common\Collections\ArrayCollection::class);
    }
    private function getOtherRelationProperty(\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo, \PhpParser\Node\Stmt\Property $property) : ?\PhpParser\Node\Stmt\Property
    {
        $doctrineRelationTagValueNode = $phpDocInfo->getByType(\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface::class);
        if (!$doctrineRelationTagValueNode instanceof \Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface) {
            return null;
        }
        $fullyQualifiedTargetEntity = $doctrineRelationTagValueNode->getFullyQualifiedTargetEntity();
        if ($fullyQualifiedTargetEntity === null) {
            return null;
        }
        $otherProperty = $this->doctrineEntityManipulator->resolveOtherProperty($property);
        if ($otherProperty === null) {
            return null;
        }
        // get the class property and remove "mappedBy/inversedBy" from annotation
        $relatedEntityClass = $this->nodeRepository->findClass($fullyQualifiedTargetEntity);
        if (!$relatedEntityClass instanceof \PhpParser\Node\Stmt\Class_) {
            return null;
        }
        foreach ($relatedEntityClass->getProperties() as $relatedEntityClassStmt) {
            if (!$this->isName($relatedEntityClassStmt, $otherProperty)) {
                continue;
            }
            return $relatedEntityClassStmt;
        }
        return null;
    }
}
