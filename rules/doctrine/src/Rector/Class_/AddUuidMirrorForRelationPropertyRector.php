<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Doctrine\Rector\Class_;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\PropertyProperty;
use _PhpScoper0a6b37af0871\PhpParser\Node\VarLikeIdentifier;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\Doctrine\ToManyTagNodeInterface;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\Doctrine\ToOneTagNodeInterface;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinColumnTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\OneToOneTagValueNode;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\Doctrine\Collector\UuidMigrationDataCollector;
use _PhpScoper0a6b37af0871\Rector\Doctrine\PhpDocParser\Ast\PhpDoc\PhpDocTagNodeFactory;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://spaceflow.io/ for sponsoring this rule - visit them on https://github.com/SpaceFlow-app
 *
 * @see \Rector\Doctrine\Tests\Rector\Class_\AddUuidMirrorForRelationPropertyRector\AddUuidMirrorForRelationPropertyRectorTest
 */
final class AddUuidMirrorForRelationPropertyRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var PhpDocTagNodeFactory
     */
    private $phpDocTagNodeFactory;
    /**
     * @var UuidMigrationDataCollector
     */
    private $uuidMigrationDataCollector;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Doctrine\PhpDocParser\Ast\PhpDoc\PhpDocTagNodeFactory $phpDocTagNodeFactory, \_PhpScoper0a6b37af0871\Rector\Doctrine\Collector\UuidMigrationDataCollector $uuidMigrationDataCollector)
    {
        $this->phpDocTagNodeFactory = $phpDocTagNodeFactory;
        $this->uuidMigrationDataCollector = $uuidMigrationDataCollector;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Adds $uuid property to entities, that already have $id with integer type.' . 'Require for step-by-step migration from int to uuid.', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class SomeEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="AnotherEntity", cascade={"persist", "merge"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $amenity;
}

/**
 * @ORM\Entity
 */
class AnotherEntity
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    private $uuid;
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class SomeEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="AnotherEntity", cascade={"persist", "merge"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $amenity;

    /**
     * @ORM\ManyToOne(targetEntity="AnotherEntity", cascade={"persist", "merge"})
     * @ORM\JoinColumn(nullable=true, referencedColumnName="uuid")
     */
    private $amenityUuid;
}

/**
 * @ORM\Entity
 */
class AnotherEntity
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    private $uuid;
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
        if (!$this->isDoctrineEntityClass($node)) {
            return null;
        }
        // traverse relations and see which of them have freshly added uuid on the other side
        foreach ($node->getProperties() as $property) {
            if ($this->shouldSkipProperty($node, $property)) {
                continue;
            }
            $node->stmts[] = $this->createMirrorNullable($property);
        }
        return $node;
    }
    private function shouldSkipProperty(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property $property) : bool
    {
        // this relation already is or has uuid property
        if ($this->isName($property, '*Uuid')) {
            return \true;
        }
        $uuidPropertyName = $this->getName($property) . 'Uuid';
        if ($this->hasClassPropertyName($class, $uuidPropertyName)) {
            return \true;
        }
        $targetEntity = $this->getTargetEntity($property);
        if ($targetEntity === null) {
            return \true;
        }
        if (!\property_exists($targetEntity, 'uuid')) {
            return \true;
        }
        /** @var PhpDocInfo|null $propertyPhpDocInfo */
        $propertyPhpDocInfo = $property->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($propertyPhpDocInfo === null) {
            return \true;
        }
        $oneToOneTagValueNode = $propertyPhpDocInfo->getByType(\_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\OneToOneTagValueNode::class);
        // skip mappedBy oneToOne, as the column doesn't really exist
        if ($oneToOneTagValueNode === null) {
            return \false;
        }
        return (bool) $oneToOneTagValueNode->getMappedBy();
    }
    /**
     * Creates duplicated property, that has "*uuidSuffix"
     * and nullable join column, so we cna complete them manually
     */
    private function createMirrorNullable(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property $property) : \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property
    {
        $oldPropertyName = $this->getName($property);
        $propertyWithUuid = clone $property;
        // this is needed to keep old property name
        $this->mirrorPhpDocInfoToUuid($propertyWithUuid);
        // name must be changed after the doc comment update, because the reflection annotation needed for update of doc comment
        // would miss non existing *Uuid property
        $uuidPropertyName = $oldPropertyName . 'Uuid';
        $newPropertyProperty = new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\PropertyProperty(new \_PhpScoper0a6b37af0871\PhpParser\Node\VarLikeIdentifier($uuidPropertyName));
        $propertyWithUuid->props = [$newPropertyProperty];
        $this->addNewPropertyToCollector($property, $oldPropertyName, $uuidPropertyName);
        return $propertyWithUuid;
    }
    private function hasClassPropertyName(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class, string $uuidPropertyName) : bool
    {
        foreach ($class->getProperties() as $property) {
            if (!$this->isName($property, $uuidPropertyName)) {
                continue;
            }
            return \true;
        }
        return \false;
    }
    private function mirrorPhpDocInfoToUuid(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property $property) : void
    {
        /** @var PhpDocInfo $propertyPhpDocInfo */
        $propertyPhpDocInfo = $property->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        $newPropertyPhpDocInfo = clone $propertyPhpDocInfo;
        /** @var DoctrineRelationTagValueNodeInterface $doctrineRelationTagValueNode */
        $doctrineRelationTagValueNode = $this->getDoctrineRelationTagValueNode($property);
        if ($doctrineRelationTagValueNode instanceof \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\Doctrine\ToManyTagNodeInterface) {
            $this->refactorToManyPropertyPhpDocInfo($newPropertyPhpDocInfo, $property);
        } elseif ($doctrineRelationTagValueNode instanceof \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\Doctrine\ToOneTagNodeInterface) {
            $this->refactorToOnePropertyPhpDocInfo($newPropertyPhpDocInfo);
        }
    }
    private function addNewPropertyToCollector(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property $property, string $oldPropertyName, string $uuidPropertyName) : void
    {
        /** @var string $className */
        $className = $property->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        /** @var DoctrineRelationTagValueNodeInterface $doctrineRelationTagValueNode */
        $doctrineRelationTagValueNode = $this->getDoctrineRelationTagValueNode($property);
        $this->uuidMigrationDataCollector->addClassToManyRelationProperty($className, $oldPropertyName, $uuidPropertyName, $doctrineRelationTagValueNode);
    }
    private function refactorToManyPropertyPhpDocInfo(\_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $propertyPhpDocInfo, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property $property) : void
    {
        $doctrineJoinColumnTagValueNode = $propertyPhpDocInfo->getByType(\_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinColumnTagValueNode::class);
        if ($doctrineJoinColumnTagValueNode !== null) {
            // replace @ORM\JoinColumn with @ORM\JoinTable
            $propertyPhpDocInfo->removeTagValueNodeFromNode($doctrineJoinColumnTagValueNode);
        }
        $joinTableTagNode = $this->phpDocTagNodeFactory->createJoinTableTagNode($property);
        $propertyPhpDocInfo->addPhpDocTagNode($joinTableTagNode);
    }
    private function refactorToOnePropertyPhpDocInfo(\_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $propertyPhpDocInfo) : void
    {
        /** @var JoinColumnTagValueNode|null $joinColumnTagValueNode */
        $joinColumnTagValueNode = $propertyPhpDocInfo->getByType(\_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinColumnTagValueNode::class);
        if ($joinColumnTagValueNode !== null) {
            // remove first
            $propertyPhpDocInfo->removeByType(\_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinColumnTagValueNode::class);
            $mirrorJoinColumnTagValueNode = new \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinColumnTagValueNode(['referencedColumnName' => 'uuid', 'unique' => $joinColumnTagValueNode->getUnique(), 'nullable' => \true]);
        } else {
            $mirrorJoinColumnTagValueNode = $this->phpDocTagNodeFactory->createJoinColumnTagNode(\true);
        }
        $propertyPhpDocInfo->addTagValueNodeWithShortName($mirrorJoinColumnTagValueNode);
    }
}
