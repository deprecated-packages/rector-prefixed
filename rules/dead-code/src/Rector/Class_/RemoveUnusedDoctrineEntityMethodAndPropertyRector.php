<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\DeadCode\Rector\Class_;

use _PhpScoper0a6b37af0871\Doctrine\Common\Collections\ArrayCollection;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\IdTagValueNode;
use _PhpScoper0a6b37af0871\Rector\Caching\Contract\Rector\ZeroCacheRectorInterface;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\ClassManipulator;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\DeadCode\Doctrine\DoctrineEntityManipulator;
use _PhpScoper0a6b37af0871\Rector\DeadCode\UnusedNodeResolver\ClassUnusedPrivateClassMethodResolver;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://spaceflow.io/ for sponsoring this rule - visit them on https://github.com/SpaceFlow-app
 * @see \Rector\DeadCode\Tests\Rector\Class_\RemoveUnusedDoctrineEntityMethodAndPropertyRector\RemoveUnusedDoctrineEntityMethodAndPropertyRectorTest
 */
final class RemoveUnusedDoctrineEntityMethodAndPropertyRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector implements \_PhpScoper0a6b37af0871\Rector\Caching\Contract\Rector\ZeroCacheRectorInterface
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
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\ClassManipulator $classManipulator, \_PhpScoper0a6b37af0871\Rector\DeadCode\UnusedNodeResolver\ClassUnusedPrivateClassMethodResolver $classUnusedPrivateClassMethodResolver, \_PhpScoper0a6b37af0871\Rector\DeadCode\Doctrine\DoctrineEntityManipulator $doctrineEntityManipulator)
    {
        $this->classUnusedPrivateClassMethodResolver = $classUnusedPrivateClassMethodResolver;
        $this->classManipulator = $classManipulator;
        $this->doctrineEntityManipulator = $doctrineEntityManipulator;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Removes unused methods and properties from Doctrine entity classes', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
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
    private function removeClassMethodsByNames(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class, array $unusedMethodNames) : \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_
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
    private function resolveUnusedPrivatePropertyNames(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class) : array
    {
        $privatePropertyNames = $this->classManipulator->getPrivatePropertyNames($class);
        // get list of fetched properties
        $usedPropertyNames = $this->resolveClassUsedPropertyFetchNames($class);
        return \array_diff($privatePropertyNames, $usedPropertyNames);
    }
    /**
     * @param string[] $unusedPropertyNames
     */
    private function removeClassPrivatePropertiesByNames(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class, array $unusedPropertyNames) : \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_
    {
        foreach ($class->getProperties() as $property) {
            if ($this->hasPhpDocTagValueNode($property, \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\IdTagValueNode::class)) {
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
            $this->removeInversedByOrMappedByOnRelatedProperty($property);
        }
        return $class;
    }
    /**
     * @return string[]
     */
    private function resolveClassUsedPropertyFetchNames(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class) : array
    {
        $usedPropertyNames = [];
        $this->traverseNodesWithCallable($class->stmts, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) use(&$usedPropertyNames) {
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch) {
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
                $parentNode = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
                $this->collectionByPropertyName[$propertyName] = $parentNode;
                return null;
            }
            $usedPropertyNames[] = $propertyName;
            return null;
        });
        return $usedPropertyNames;
    }
    private function removeInversedByOrMappedByOnRelatedProperty(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property $property) : void
    {
        $otherRelationProperty = $this->getOtherRelationProperty($property);
        if ($otherRelationProperty === null) {
            return;
        }
        $this->doctrineEntityManipulator->removeMappedByOrInversedByFromProperty($otherRelationProperty);
    }
    private function isPropertyFetchAssignOfArrayCollection(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch $propertyFetch) : bool
    {
        $parentNode = $propertyFetch->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign) {
            return \false;
        }
        if (!$parentNode->expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_) {
            return \false;
        }
        /** @var New_ $new */
        $new = $parentNode->expr;
        return $this->isName($new->class, \_PhpScoper0a6b37af0871\Doctrine\Common\Collections\ArrayCollection::class);
    }
    private function getOtherRelationProperty(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property $property) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property
    {
        $targetEntity = $this->docBlockManipulator->getDoctrineFqnTargetEntity($property);
        if ($targetEntity === null) {
            return null;
        }
        $otherProperty = $this->doctrineEntityManipulator->resolveOtherProperty($property);
        if ($otherProperty === null) {
            return null;
        }
        // get the class property and remove "mappedBy/inversedBy" from annotation
        $relatedEntityClass = $this->nodeRepository->findClass($targetEntity);
        if (!$relatedEntityClass instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_) {
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
